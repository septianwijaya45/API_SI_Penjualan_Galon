<?php

namespace App\Helper;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserServices{
    public $username, $password;

    public function __construct($username, $password)
    {
        $this->username     = $username;
        $this->password     = $password;
    }

    public function validateInputLogin()
    {
        $validator = Validator::make([
            'username'     => $this->username,
            'password'  => $this->password,
        ], [
            'username'     => ['required'],
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
            $user = User::where('username', $this->username)->first();
            if(Hash::check($this->password, $user->password)){
                if($user->role_id == 1){
                    return ['status' => false, 'messages' => ['Anda Bukan Pegawai!']];
                }else{
                    $token = $user->createToken($deviceName)->plainTextToken;
                    return [
                        'status' => true, 
                        'token' => $token, 
                        'user' => $user
                    ];
                }
            }else{
                return ['status' => false, 'messages' => ['Username atau Password Salah']];
            }
        }
    }
}
?>