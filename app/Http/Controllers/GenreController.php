<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenreController extends Controller
{

    public function index()
    {
        $data = DB::table('master_genre')
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

    public function show($idmovie)
    {
        $data = DB::table('genre_movie')
                ->join('master_genre','genre_movie.idgenre','=','master_genre.idgenre')
                ->where('idmovie','=', $idmovie)
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
}
