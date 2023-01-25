<?php

namespace App\src\Auths\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'name.required'=> 'Veuillez renseigner ce champ',
            'name.string'=> 'Nous n\'acceptons pas les caractères spéciaux pour les nom',
            'name.max'=> 'Votre nom est trop long',

            'email.required'=> 'Veuillez renseigner ce champ',
            'email.email'=> 'Nous n\'acceptons pas ce genre d\'email',
            'email.unique'=> 'Votre email existe deja dans la plateforme',

            'username.required'=> 'Veuillez renseigner ce champ',
            'username.string'=> 'Nous n\'acceptons pas les caractères spéciaux pour les nom d\'uilisateur',
            'username.unique'=> 'Ce identifiant est déjà pris',

            'password.required'=> 'Veuillez renseigner ce champ',
            'password.string'=> 'Nous n\'acceptons pas les caractères spéciaux pour les nom',
            'password.max'=> 'Votre nom est trop long',

            'role_id.required'=> 'Veuillez renseigner ce champ',
            'role_id.string'=> 'Nous n\'acceptons pas les caractères spéciaux pour les nom',
            'role_id.max'=> 'Votre nom est trop long',
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required | string |max:100',
            'email'=>'required | email | unique:users,email',
            'password'=>'required |min:8',
            'role_id'=>'required',
            'username'=>'required |unique:users,username',
        ];
    }
}
