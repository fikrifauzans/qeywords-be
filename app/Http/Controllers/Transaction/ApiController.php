<?php

namespace App\Http\Controllers\Transaction;

use App\Exceptions\ErrorResponse;
use App\Handler\Response\Response;
use App\Handler\Response\ResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{

    protected Response $response;


    public function __construct(Response $response)
    {
        $this->response = $response;
    }


    public function debugApi(Request $request)
    {
        try {
            $search = $request->search;
            $apiUrl = "https://portal.qwords.com/apitest/whois.php?domain=$search";
            $response = Http::get($apiUrl);
            $responseBody = $response->body();
            $decodeResponseBody = (json_decode($responseBody));

            if (
                $decodeResponseBody?->result === 'success'
                && $decodeResponseBody?->status === 'available'
            ) {

                return $this->response
                    ->setData($decodeResponseBody)
                    ->setMessage(ResponseMessage::SHOW_DEFAULT_MESSAGE)
                    ->setMeta()
                    ->get();;
            } else {
                throw new ErrorResponse("Domain Invalid Atau Tidak Di Temukan");
            }
        } catch (\Throwable $e) {
            throw new ErrorResponse($e->getMessage());
        }
    }
}
