<?php

namespace App\Http\Controllers\Api;

use App\Helper\UserServices;
use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    function login(Request $request)
    {
        $response = (new UserServices($request->username, $request->password))->login($request->deviceName);
        return response()->json($response);
    }

    function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout Success', 'data' => $request]);
    }

    
    function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'              =>  'required',
            'tempat_lahir'      =>  'required',
            'tanggal_lahir'     =>  'required',
            'jenis_kelamin'     =>  'required',
            'alamat'            =>  'required',
            'desa'           =>  'required'
        ]);

        if($validator->fails()){
            return [
                'status'    => false,
                'messages'  => $validator->messages()
            ];
        }

        $user               = new User();
        $user->username     = $request->nama;
        $user->password     = bcrypt('pelanggan');
        $user->role         = 4;
        $user->created_at   = Carbon::now();
        $user->updated_at   = Carbon::now();
        $user->save();

        $pelanggan = new Pelanggan();
        $pelanggan->nama              = $request->nama;
        $pelanggan->tempat_lahir      = $request->tempat_lahir;
        $pelanggan->tanggal_lahir     = $request->tanggal_lahir;
        $pelanggan->jenis_kelamin     = $request->jenis_kelamin;
        $pelanggan->alamat            = $request->alamat;
        $pelanggan->member            = 0;
        $pelanggan->id_desa           = $request->desa;
        $pelanggan->id_user           = $user->id;
        $pelanggan->lang              = $request->lang;
        $pelanggan->long              = $request->long;
        $pelanggan->created_at        = Carbon::now();
        $pelanggan->updated_at        = Carbon::now();
        $pelanggan->save();

        return response()->json([
            'status'    => true,
            'data'      => $pelanggan
        ]);
    }

    function edit($id){
        $profile = DB::select("
            SELECT u.username, p.*
            FROM users u, pelanggans p
            WHERE u.id = p.id_user AND u.id = $id
        ");

        return response()->json([
            'status'    => true,
            'data'      => $profile
        ]);
    }

    function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nama'              =>  'required',
            'tempat_lahir'      =>  'required',
            'tanggal_lahir'     =>  'required',
            'jenis_kelamin'     =>  'required',
            'alamat'            =>  'required',
            'desa'           =>  'required'
        ]);

        if($validator->fails()){
            return [
                'status'    => false,
                'messages'  => $validator->messages()
            ];
        }

        $pelanggan = Pelanggan::where('id_user', $id)->update([
            'nama'              => $request->nama,
            'tempat_lahir'      => $request->tempat_lahir,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'alamat'            => $request->alamat,
            'id_desa'           => $request->desa,
            'lang'              => $request->lang,
            'long'              => $request->long,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
        ]);

        return response()->json([
            'status'    => true,
            'data'      => $pelanggan
        ]);
    }
}
