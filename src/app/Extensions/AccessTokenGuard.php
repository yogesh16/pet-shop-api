<?php

namespace App\Extensions;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class AccessTokenGuard implements Guard
{
    use GuardHelpers;

    private $inputKey = '';
    private $storageKey = '';
    private $request;

    public function __construct
    (
        UserProvider $provider,
        Request $request,
        $configuration
    )
    {
        $this->provider = $provider;
        $this->request = $request;
        // key to check in request
        $this->inputKey = 'access_token';
        // key to check in database
        $this->storageKey = 'access_token';
    }

    public function user ()
    {
        if (! is_null($this->user))
        {
            return $this->user;
        }

        $user = null;

        // retrieve via token
        $token = $this->request->bearerToken();

        if ($token !== null && $token !== '')
        {
            // the token was found, how you want to pass?
            $user = $this->provider->retrieveByToken($this->storageKey, $token);
        }

        return $this->user = $user;
    }

    /**
     * Get the token for the current request.
     *
     * @return string
     */
    public function getTokenForRequest ()
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
    public function validate (array $credentials = [])
    {
        if (array_key_exists($this->inputKey, $credentials))
        {
            return false;
        }

        $credentials = [ $this->storageKey => $credentials[$this->inputKey] ];

        if ($this->provider->retrieveByCredentials($credentials))
        {
            return true;
        }

        return false;
    }

    public function attempt(array $credentials = [], $remember = false)
    {

        $user = $this->provider->retrieveByCredentials($credentials);
        $this->lastAttempted = $user;

        // If an implementation of UserInterface was returned,
        // we'll ask the provider to validate the user against
        // the given credentials, and if they are in fact valid
        // we'll log the users into the application and return true.
        if ($user && $this->hasValidCredentials($user, $credentials))
        {
            $this->user = $user;
            //Todo update last login time.
            return true;
        }

        return false;
    }

    protected function hasValidCredentials($user, $credentials)
    {
        return ! is_null($user) &&
            $this->provider->validateCredentials($user, $credentials);
    }
}
