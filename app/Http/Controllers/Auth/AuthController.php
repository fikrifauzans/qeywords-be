<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\ErrorMessage;
use App\Exceptions\ErrorResponse;
use App\Exceptions\ErrorStatus;
use App\Handler\Response\Response;
use App\Handler\Response\ResponseMessage;
use App\Handler\Response\ResponseStatus;
use App\Http\Controllers\Auth\Configurator\AuthConfigurator;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Auth\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use League\OAuth2\Server\AuthorizationServer;
use Laravel\Passport\TokenRepository;


class AuthController extends Controller
{

    protected AuthorizationServer $server;
    protected TokenRepository $tokens;
    protected AuthRepository $repository;
    protected Response $response;

    public function __construct(
        AuthorizationServer $server,
        TokenRepository $tokens,
        AuthRepository $repository,
        Response $response

    ) {
        $this->server = $server;
        $this->tokens = $tokens;
        $this->repository = $repository;
        $this->response = $response;
    }
    public function login(Request $request)
    {

        # Validate Request
        $this->validateRequest(
            $request,
            AuthConfigurator::ALLOWED_BODY_FIELDS_LOGIN,
            AuthConfigurator::RULES_BODY_LOGIN
        );

        # Find User By Email
        $user = $this->repository->findExistingUser($request);
        $password = $request->password;

        if (!$user || !Hash::check($password, $user->password)) {
            throw new ErrorResponse(
                ErrorMessage::AUTH_FAILED,
                ErrorStatus::NOT_FOUND
            );
        }
        return $this->refreshToken($request, $user);
    }


    # @Nakamacode - F
    function refreshToken(Request $request, $user = [])
    {

        $authorizationHeader = $request->header('Authorization');
        # If Login Email & Password
        if (
            $request->has(AuthConfigurator::PARAMETER_EMAIL)
            && $request->has(AuthConfigurator::PARAMETER_PASSWORD)
        ) {
            $userEmail = $request->email;
            $userPassword = $request->password;

            # If with Header Token
        } else if ($authorizationHeader && preg_match(
            '/Bearer\s+(.*)$/i',
            $authorizationHeader,
            $matches
        )) {
            $bearerToken = $matches[1];
            $decodedToken = base64_decode($bearerToken);
            list($userEmail, $userPassword) = explode(':', $decodedToken);
        }

        # Payload For Generate Token
        $payload = [
            'grant_type'    => 'password',
            'client_id'     => AuthConfigurator::CLIENT_ID(),
            'client_secret' => AuthConfigurator::CLIENT_SECRET(),
            'username'      => $userEmail,
            'password'      => $userPassword,
            'scope'         => '',
        ];

        $httpResponse = app()->handle(Request::create(AuthConfigurator::URL_AUTH, 'POST', $payload));
        $httResponseCode = $httpResponse->getStatusCode();
        $token = json_decode($httpResponse->getContent(), true);

        if ($httResponseCode === ResponseStatus::RESPONSE_SUCCESS) {
            return $this->response->setData([
                'token' => $token,
                'user' => $user
            ])->setMessage(ResponseMessage::GENERATED_LOGIN_MESSAGE)
                ->get();
        }

        throw new ErrorResponse(ErrorMessage::AUTH_FAILED_GENERATE_TOKEN, ErrorStatus::INVALID);
    }


    public function register(Request $request)
    {
        $this->validateRequest($request, AuthConfigurator::ALLOWED_BODY_FIELDS_REGISTER, AuthConfigurator::RULES_BODY_REGISTER);
        $user = $this->repository->registerNewUser([
            AuthConfigurator::PARAMETER_NAME => $request->input(AuthConfigurator::PARAMETER_NAME),
            AuthConfigurator::PARAMETER_EMAIL => $request->input(AuthConfigurator::PARAMETER_EMAIL),
            AuthConfigurator::PARAMETER_PASSWORD => bcrypt($request->input(AuthConfigurator::PARAMETER_PASSWORD)),
        ]);
        return  $this->response->setData($user)->setMessage(ResponseMessage::CREATED_DEFAULT_MESSAGE, ResponseStatus::CREATED_STATUS)->get();
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->response->setMessage(
            ResponseMessage::GENERATED_LOGOUT_MESSAGE,
            ResponseStatus::RESPONSE_SUCCESS
        );
    }

    public function profile()
    {
        return $this->response
            ->setData(Auth::user())
            ->setMessage(
                ResponseMessage::SHOW_DEFAULT_MESSAGE,
                ResponseStatus::RESPONSE_SUCCESS
            )->get();
    }
}
