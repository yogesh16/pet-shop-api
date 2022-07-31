<?php

namespace App\Extensions;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class AccessTokenGuard implements Guard
{
    use GuardHelpers;

    private string $inputKey = '';
    private string $storageKey = '';
    private Request $request;

    public function __construct(
        UserProvider $provider,
        Request $request
    ) {
        $this->provider = $provider;
        $this->request = $request;
        // key to check in request
        $this->inputKey = 'access_token';
        // key to check in database
        $this->storageKey = 'access_token';
    }

    public function user()
    {
        if (isset($this->user->id)) {
            return $this->user;
        }

        $user = null;

        // retrieve via token
        $token = $this->request->bearerToken();

        $this->user = $this->provider->retrieveByToken($this->storageKey, $token);

        return $this->user;
    }

    /**
     * Get the token for the current request.
     *
     * @return string
     */
    public function getTokenForRequest(): string|null
    {
        return $this->request->bearerToken();
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array $credentials
     *
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        $credentials = [
            $this->storageKey => $credentials[$this->inputKey] ?? null,
        ];

        if ($this->provider->retrieveByCredentials($credentials)) {
            return true;
        }

        return false;
    }

    public function attempt(array $credentials = [], bool $remember = false): bool
    {
        $user = $this->provider->retrieveByCredentials($credentials);

        // If an implementation of UserInterface was returned,
        // we'll ask the provider to validate the user against
        // the given credentials, and if they are in fact valid
        // we'll log the users into the application and return true.
        if ($user && $this->hasValidCredentials($user, $credentials)) {
            $this->user = $user;
            return true;
        }

        return false;
    }

    protected function hasValidCredentials(Authenticatable $user, array $credentials): bool
    {
        return $this->provider->validateCredentials($user, $credentials);
    }
}
