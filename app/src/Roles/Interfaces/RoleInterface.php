<?php
namespace App\src\Roles\Interfaces;

interface RoleInterface
{

    public function index();

    public function store(array $data);

    public function show($uuid);

    public function update(array $data, $uuid);

    public function destroy($uuid);

}
