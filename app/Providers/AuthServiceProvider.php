<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use App\Models\Passport\AuthCode;
use App\Models\Passport\RefreshToken;
use App\Models\Passport\Token;
use Carbon\Carbon;
use Laravel\Passport\PersonalAccessClient as PassportPersonalAccessClient;
use Laravel\Passport\RefreshToken as PassportRefreshToken;
use Laravel\Passport\Token as PassportToken;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        $this->registerPolicies();


        // Passport::loadKeysFrom(__DIR__ . '/../secrets/oauth');
        Passport::hashClientSecrets();
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(Carbon::now()->addMinutes(15));
        Passport::useTokenModel(PassportToken::class);
        Passport::useRefreshTokenModel(PassportRefreshToken::class);
        Passport::useAuthCodeModel(AuthCode::class);
        Passport::usePersonalAccessClientModel(PassportPersonalAccessClient::class);

    }
}
