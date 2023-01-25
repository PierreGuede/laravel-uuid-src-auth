<?php

namespace App\src\Auths\Interfaces;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\src\Roles\Role;
use App\Interfaces\RoleInterface;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\UltimateException;
use App\Mail\Auths\ResetPasswordCodeMail;
use App\src\Users\Resources\UserResource;
use App\src\Users\Interfaces\UserInterface;

Class AuthInterfaceRepository implements AuthInterface
{

    private $model_user, $model_role, $user;

    public function __construct(UserInterface $user,Role $role, User $model)
    {
        $this->model_user = $user;
        $this->model_role = $role;
        $this->user = $model;
    }

    public function login(array $data) : array{
        try {
            $remember = $data['remember'] ?? false;
            $array=[filter_var($data['identifier'],FILTER_VALIDATE_EMAIL) ? 'email' : 'username'=> $data['identifier'] , 'password'=>$data['password']];
            $user_field=$this->user->where('username',$data['identifier'])->orWhere('email',$data['identifier'])->first();
            if (password_verify($data['password'],$user_field->password)) {
                if ($user_field->web_type == null || $user_field->is_connected == 0 || $user_field->updated_at->isYesterday()) {
                    if (! Auth::attempt($array, $remember)) {
                        throw new CustomException("Le nom d'utilisateur ou l'adresse e-mail ou le mot de passe est invalide");
                    }
                    $user_field->web_type = $_SERVER['HTTP_USER_AGENT'];
                    $user_field->is_connected = 1;
                    $user_field->updated_at = now();
                    $user_field->save();
                    $user = Auth::user();
                    $token = $user->createToken('main')->plainTextToken;
                    return [
                        'token' => $token,
                    ];
                } else {
                    return [
                        'message'=>'Vous êtes connecté avec un appareil, veuillez vous deconnecter d\'abord avec cet appareil'
                    ];
                }

            }
            else {
                throw new CustomException("Le nom d'utilisateur ou l'adresse e-mail ou le mot de passe est invalide");
            }

        } catch (\Throwable $th) {
            Log::error($th);
            throw new  UltimateException($th, 400);
        }
    }

    public function register(array $data){
        try {
            $role_response = $this->model_role->whereName($data['role_id'])->first();
            $user_data = $role_response->user()->create($data);
            $user_data->generateTwoFactorCode();
            return $user_data;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw new UltimateException("Impossible de s'inscrire pour le moment", 400);
        }
    }

    public function me() :UserResource {
        try {
            $user = $this->model_user->show(request()->user()->id);
            return new UserResource($user);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function findByMail(array $data)
    {
        $user_data = $this->user->whereEmail($data['email'])->first();
        $user_data->password_reset_code = $user_data->id[5].$user_data->id[12].$user_data->id[7].Str::random(3);
        $user_data->save();
        Mail::to($user_data->email)->send(new ResetPasswordCodeMail([
            'name'=>$user_data->name,
        ]));
    }

    public function resetPassword(array $data)
    {
        try {
            $user = $this->user->wherePasswordResetCode($data['code'])->first();
            $user->password = bcrypt($data['password']);
            $user->save();
            return $user;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function updatePassword($uuid, array $data) : UserResource
    {
        try {
            $user = $this->model_user->show($uuid);
            $user->update([
                'password' => bcrypt($data['password'])
            ]);
            return new UserResource($user);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

     public function verifyEmail($uuid)
     {

     }
    public function logOut()
    {
        /** @var User $user */
        $user_request = request()->user();
        $user_field=$this->model_user->show($user_request->id);
            $user_field['web_type'] = null;
            $user_field['is_connected'] = 0;
        $user_field->save();
        Auth::guard('web')->logout();
        $user=Auth::user();
        $user->currentAccessToken()->delete();
        return response([
            'success'=>'Utilisateur déconnecté'
        ]);
    }

}
