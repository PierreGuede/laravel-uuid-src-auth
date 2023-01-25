<?php

namespace App\src\Auths\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\src\Auths\Interfaces\AuthInterface;
use App\src\Auths\Requests\LoginRequest;
use App\src\Auths\Requests\RegisterRequest;

class AuthController extends Controller
{
    private $auth_interface;
    public function __construct(AuthInterface $auth)
    {
        $this->auth_interface = $auth;
    }

    public function login (LoginRequest $request)
    {
        return $this->auth_interface->login($request->validated());
    }

    public function register(RegisterRequest $request)
    {
        return $this->auth_interface->register($request->validated());
    }

    public function me()
    {
        return $this->auth_interface->me();
    }

    public function updatePassword($uuid, Request $data)
    {
        return $this->auth_interface->updatePassword($uuid,$data->all());
    }

    public function findByMail(Request $data)
    {
        return $this->auth_interface->findByMail($data->all());
    }
    public function resetPassword(Request $data)
    {
        return $this->auth_interface->resetPassword($data->all());
    }

    /**
     * It logs out the user.
     */
    public function logOut()
    {
        return $this->auth_interface->logOut();
    }
}
