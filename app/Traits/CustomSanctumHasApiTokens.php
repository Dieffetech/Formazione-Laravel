<?php

namespace App\Traits;

use App\Classes\TokenAbility;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;
use function Psy\debug;

trait CustomSanctumHasApiTokens
{
    use HasApiTokens;

    public function createToken(string $name, $expireMinutes = null, array $abilities = ['*'], $length = 40)
    {
        /** @var PersonalAccessToken $token */

        $token = $this->tokens()
            ->create([
                'name' => $name,
                'token' => hash('sha256', $plainTextToken = Str::random($length)),
                'abilities' => $abilities,
                'expired_at' => $expireMinutes ? now()->addMinutes($expireMinutes) : null,
            ]);

        return new NewAccessToken($token, $plainTextToken);
    }

    public function createAuthToken(string $name, $expireMinutes = null, array $abilities = [])
    {
        return $this->createToken($name, $expireMinutes ?? config('sanctum-refresh-token.auth_token_expiration'), array_merge($abilities, ['auth']));
    }

    public function createRefreshToken($name, $expireMinutes = null)
    {
        return $this->createToken($name, $expireMinutes ?? config('sanctum-refresh-token.refresh_token_expiration'), ['refresh']);
    }

    public function createResetPasswordToken($name, $expireMinutes = null)
    {
        return $this->createToken($name, $expireMinutes ?? config('sanctum-refresh-token.reset_password_token_expiration'), ['reset-password','auth']);
    }

    /**
     * @param $name
     * @param $tokenAbilities []
     * @return array
     */
    public function createTokenByAbilities($name, $tokenAbilities, $deleteTokens = true)
    {
        if ($deleteTokens) {
            $this->tokens()->delete();
        }

        foreach ($tokenAbilities as $tokenAbility) {
            $return[] = $this->createToken($name, $tokenAbility['expire_minutes'] ?? config('sanctum-refresh-token.default_token_expiration'), $tokenAbility['ability'], $tokenAbility['length'] ?? 40);
        }

        return $return;
    }

    public function createAllAuthTokens(string $name)
    {
        return [
            'token' => $this->createAuthToken($name)->plainTextToken,
            'refresh_token' => $this->createRefreshToken($name)->plainTextToken,
        ];
    }

}
