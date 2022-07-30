<?php

namespace App\Services;

use App\Models\JwtToken;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;
use Lcobucci\JWT\Validation\Constraint\SignedWith;

/**
 * Class JWTService
 *
 * @package App\Services
 *
 * Service helper for JWT
 */
class JWTService
{
    private static function getConfig(): Configuration
    {
        $config = Configuration::forAsymmetricSigner
        (
            new Signer\Rsa\Sha256(),
            InMemory::file(storage_path('app/key/jwtRS256.key')),
            InMemory::file(storage_path('app/key/jwtRS256.key.pub'))
        );

        $config->setValidationConstraints
        (
            new IssuedBy(config('app.url')),
            new PermittedFor(config('app.url')),
            new SignedWith($config->signer(), $config->verificationKey())
        );

        return $config;
    }

    public static function getToken(User $user): string
    {
        $config = self::getConfig();
        $now = new \DateTimeImmutable();

        $token = $config
            ->builder()
            ->issuedBy(config('app.url'))
            ->permittedFor(config('app.url'))
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now->modify('+1 minute'))
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('user_uuid', $user->uuid)
            ->getToken($config->signer(), $config->signingKey())
            ->toString();

        $jwt =
        [
            'user_id' => $user->id,
            'access_token' => $token,
            'token_title' => 'Login',
        ];
        JwtToken::create($jwt);

        return $token;
    }

    public static function parseToken(string $token): User|null
    {
        $config = self::getConfig();
        $parsed = $config->parser()->parse($token);
        $constraints = $config->validationConstraints();
        try
        {
            $config->validator()->assert($parsed, ...$constraints);
        }
        catch(\Exception $exp)
        {
            Log::error('JWTService.parseToken', [json_encode($exp)]);
            return null;
        }
        // @phpstan-ignore-next-line
        $claims = $parsed->claims();

        return User::uuid($claims->get('user_uuid'))->first();
    }
}
