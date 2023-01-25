<?php

namespace App\src\Users\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'uuid'=>$this->id,
            'username'=>$this->username,
            'name'=>$this->name,
            'email'=>$this->email,
            'role_id'=>$this->role->name,
            'email_verified_at'=>$this->email_verified_at,
            'two_factor_code'=>$this->two_factor_code,
            'two_factor_expires_at'=>$this->two_factor_expires_at,
            'created_at'=>$this->created_at,
            'web_type'=>$this->web_type,
            'is_connected'=>$this->is_connected,
        ];
    }
}
