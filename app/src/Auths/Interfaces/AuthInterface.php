<?php
namespace App\src\Auths\Interfaces;

use App\src\Users\Resources\UserResource;
use Illuminate\Http\Request;

interface AuthInterface
{
    public function login(array $data) : array;
    public function register(array $data);
    public function me() : UserResource;
    public function updatePassword($uuid, array $data) : UserResource;
    public function findByMail(array $data);
    public function resetPassword(array $data);
    public function logOut();
}
