<?php

namespace App\src\Users\Interfaces;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\src\Users\Resources\UserResource;

Class UserInterfaceRepository implements UserInterface
{
    private $model;
    public function __construct( User $user )
    {
        $this->model = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(array $data):UserResource
    {
        try {
            DB::beginTransaction();
                $response = $this->model->save($data);
            DB::commit();
            return new UserResource($response);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid):UserResource
    {
        try {
            DB::beginTransaction();
                $response=$this->model->find($uuid);
            DB::commit();
            return new UserResource($response);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(array $data, $uuid):UserResource
    {
        try {
            DB::beginTransaction();
                $update = $this->model->find($uuid);
                $update->update($data);
            DB::commit();
            return new UserResource($update);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        //
    }
}
