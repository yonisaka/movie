<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TanggapanController extends Controller
{

    public function index(Request $request, $idmovie)
    {
        $data = DB::table('tanggapan')->where('idmovie','=',$idmovie)
                ->join('user','tanggapan.iduser','=','user.iduser')
                ->select('tanggapan.*','user.nama')
                ->get();

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

    public function store(Request $request, $idmovie, $iduser)
    {
        $rating = $request->input('rating');
        $review = $request->input('review');

        $data = DB::table('tanggapan')->insert(
            [
                'idmovie' => $idmovie,
                'iduser' => $iduser,
                'rating' => $rating,
                'review' => $review
            ]
        );

        if($data){
            $res['message'] = "Success!";
            $res['value'] = $data;
            return response($res);
        }
    }
}
