<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        $data = DB::table('user')->get();

        if(count($data) > 0){ 
            $res['message'] = "Success!";
            $res['values'] = $data;
            return response($res);
        }
        else{
            $res['message'] = "Empty!";
            return response($res);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string',
            'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/'
        ]);
        $generate_id = DB::select("SELECT iduser, SUBSTRING(iduser,-2)'nomor' FROM user ORDER BY iduser DESC LIMIT 0,1");
        $generate_id = $generate_id['0'];
        $number = $generate_id->nomor + 1;
        $zero = '';
        for ($i = strlen($number); $i < 2; $i++) {
            $zero .= '0';
        }
        
        $iduser = 'U'. $zero . $number;
        $nama = $request->input('nama');
        $password = md5($request->input('password'));

        $data = DB::table('user')->insert(
            [
                'iduser' => $iduser,
                'nama' => $nama,
                'password' => $password
            ]
        );
        
        if($data){
            $res['message'] = "Success!";
            $res['value'] = $data;
            return response($res);
        }
    }

    public function auth(Request $request){
        $nama = $request->input('nama');
        $password = md5($request->input('password'));

        $data = DB::table('user')->where('nama',$nama)->first();
        if($data){
            if($password == $data->password){
                $res['message'] = "Success login";
                $res['value'] = $data;
                return response($res);
            }else{
                $res['message'] = "Username or Password incorrect";
                return response($res);
            }
        }else{
            $res['message'] = "gagal";
            return response($res);
        }
    }
}
