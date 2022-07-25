<?php


namespace App\Services;

use Illuminate\Support\Facades\Log;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use App\Models\User;

/**
 * Class JWTService
 * @package App\Services
 * Service helper for JWT
 */
class JWTService
{
    private static function getConfig() : Configuration
    {
        $config = Configuration::forAsymmetricSigner(
            new Signer\Rsa\Sha256(),
            InMemory::file(storage_path('app/key/jwtRS256.key')),
            InMemory::file(storage_path('app/key/jwtRS256.key.pub'))
        );

        $config->setValidationConstraints(
            new IssuedBy(config('app.url')),
            new PermittedFor(config('app.url')),
            new SignedWith($config->signer(), $config->verificationKey())
        );

        return $config;
    }

    public static function getToken(string $userId) : string
    {
        $config = self::getConfig();
        $now    = new \DateTimeImmutable();

        return $config
            ->builder()
            ->issuedBy(config('app.url'))
            ->permittedFor(config('app.url'))
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now->modify('+1 minute'))
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('user_uuid', $userId)
            ->withHeader('foo', 'bar')
            ->getToken($config->signer(), $config->signingKey())
            ->toString();
    }

    public static function parseToken(string $token) : User|null
    {
        $config = self::getConfig();
        $parsed = $config->parser()->parse($token);
        $constraints = $config->validationConstraints();
        try{
            $config->validator()->assert($parsed, ...$constraints);
        }catch(RequiredConstraintsViolated $exp){
            Log::error('JWTService.parseToken', [json_encode($exp)]);
            return null;
        }
        // @phpstan-ignore-next-line
        $claims = $parsed->claims();
        if(isset($claims)){
            return User::where('id', $claims->get('user_uuid'))->first();
        }
        return null;
    }
}