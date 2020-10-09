<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{

    public function index()
    {
        $data = DB::table('movie')->get();
        for ($i = 0; $i < count($data); $i++){
            $movie = $data[$i];
            $result[] = array(
                'judul' => $movie->judul,
                'poster' => url("/poster/".$movie->idmovie.'.'.$movie->extention_poster)
            );
            
        }

        if(count($data) > 0){ 
            $res['message'] = "Success!";
            $res['values'] = $result;
            return response($res);
        }
        else{
            $res['message'] = "Empty!";
            return response($res);
        }
    }

    public function movie_by_genre($idgenre)
    {
        $data = DB::table('movie')->join('genre_movie','movie.idmovie','=','genre_movie.idmovie')->where('idgenre','=',$idgenre)->get();
        for ($i = 0; $i < count($data); $i++){
            $movie = $data[$i];
            $result[] = array(
                'judul' => $movie->judul,
                'poster' => url("/poster/".$movie->idmovie.'.'.$movie->extention_poster)
            );
            
        }

        if(count($data) > 0){ 
            $res['message'] = "Success!";
            $res['values'] = $result;
            return response($res);
        }
        else{
            $res['message'] = "Empty!";
            return response($res);
        }
    }

    public function show($idmovie)
    {
        $data = DB::table('movie')->where('idmovie','=', $idmovie)->get();
        $rating = DB::select("SELECT SUBSTRING(SUM(rating)/COUNT(rating), 1,3) AS 'rating' FROM tanggapan WHERE idmovie = '$idmovie'");
        $rating = $rating[0];
        $rating = $rating->rating;
        $movie = $data[0];
        $poster = url("/poster/".$idmovie.'.'.$movie->extention_poster);
        $result = array(
            'idmovie' => $movie->idmovie,
            'judul' => $movie->judul,
            'poster' => $poster,
            'tanggal_tayang' => $movie->tanggal_tayang,
            'pemain' => $movie->pemain,
            'sinopsis' => $movie->sinopsis,
            'rating' => $rating
        );
        $result = (object)$result;
        // print_r($poster);
        // exit();

        if(count($data) > 0){ 
            $res['message'] = "Success!";
            $res['values'] = $result;
            return response($res);
        }
        else{
            $res['message'] = "Empty!";
            return response($res);
        }
    }

    public function store(Request $request, $iduser)
    {
        $judul = $request->input('judul');
        $tanggal_tayang = $request->input('tanggal_tayang');
        $pemain = $request->input('pemain');
        $sinopsis = $request->input('sinopsis');
        // generate id
        $generate_id = DB::select("SELECT idmovie AS 'nomor' FROM movie ORDER BY idmovie DESC LIMIT 0,1");
        $generate_id = $generate_id['0'];
        $number = $generate_id->nomor + 1;
        // file
        $file = $request->file('poster');
        $filename = $number.'.'.$file->getClientOriginalExtension();
        $extention_poster = $file->getClientOriginalExtension();
        // print_r($filename);
        // exit();
        $path = 'poster';
        $file->move($path,$filename);

        $data = DB::table('movie')->insert(
            [
                'judul' => $judul,
                'iduser_yang_posting' => $iduser,
                'pemain' => $pemain,
                'tanggal_tayang' => $tanggal_tayang,
                'sinopsis' => $sinopsis,
                'extention_poster' => $extention_poster
            ]
        );

        if($data){
            $res['message'] = "Success!";
            $res['value'] = $data;
            return response($res);
        }
    }
}
