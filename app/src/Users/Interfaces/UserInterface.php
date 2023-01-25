<?php
namespace App\src\Users\Interfaces;

use App\src\Users\Resources\UserResource;
use App\src\Users\User;

interface UserInterface
{

    public function index();

    public function store(array $data):UserResource;

    public function show($uuid):UserResource;

    public function update(array $data, $uuid):UserResource;

    public function destroy($uuid);

}
