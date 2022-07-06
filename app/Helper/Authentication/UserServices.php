<?php

namespace App\Helper;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserServices{
    public $email, $password;

    public function __construct($email, $password)
    {
        $this->email    = $email;
        $this->password = $password;
    }

    public function validateInputLogin()
    {
        $validator = Validator::make([
            'email'     => $this->email,
            'password'  => $this->password,
        ], [
            'email'     => ['required'],
            'password'  => ['required']
        ]);

        if($validator->fails()){
            return [
                'status'    => false,
                'messages'  => $validator->messages()
            ];
        }else{
            return [
                'status'    => true
            ];
        }
    }

    public function login($deviceName)
    {
        $validate = $this->validateInputLogin();
        if($validate['status'] == false){
            return $validate;
        }else{
            $user = User::where('email', $this->email)->first();
            if(Hash::check($this->password, $user->password)){
                if($user->role_id == 1){
                    return ['status' => false, 'messages' => ['Anda Bukan Pegawai!']];
                }else{
                    $token = $user->createToken($deviceName)->plainTextToken;
                    return ['status' => true, 'token' => $token, 'user' => $user];
                }
            }else{
                return ['status' => false, 'messages' => ['Email atau Password Salah']];
            }
        }
    }
}
?>