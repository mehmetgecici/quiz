<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getApiMovies(){
        $name = request('name');
        if ($name == null){
            return response()->json([
                'message' => 'Lutfen Film Ismini Giriniz !'
            ], 400);
        }

        if (gettype($name) !='string'){
            return response()->json([
                'message' => 'Lutfen Film Ismini Doğru Formatta Giriniz !'
            ], 400);
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://moviesdatabase.p.rapidapi.com/titles/search/keyword/".$name,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: moviesdatabase.p.rapidapi.com",
                "X-RapidAPI-Key: a747e40327mshc551cd40fe4cc18p1ad2bajsnf2e00d187c17"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return response()->json([
                'message' => 'Curl Bağlantı Hatası : '. $err
            ], 500);
        }elseif ($response==null){
            return response()->json([
                'message' => 'Veri Bulunamadı'
            ], 404);
        } else {
            $data = array();
            $response = json_decode($response, true);
            foreach ($response['results'] as $resp) {
                $film = array();
                $film['title'] = $resp['titleText']['text'];

                if ($resp['primaryImage'] != null) {
                    $film['image'] =  $resp['primaryImage']['url'];
                } else {
                    $film['image'] = null;
                }

                $film['year'] = $resp['releaseYear']['year'];
                array_push($data, $film);

            }
            $json_data = json_encode(['data' => $data], JSON_UNESCAPED_SLASHES);
            return $json_data;

        }

    }

    public function getApiAdvanced(){
        $name = request('name');

        if ($name == null){
            return response()->json([
                'message' => 'Lutfen Film Ismini Giriniz !'
            ], 400);
        }

        if (gettype($name) !='string'){
            return response()->json([
                'message' => 'Lutfen Film Ismini Doğru Formatta Giriniz !'
            ], 400);
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://advanced-movie-search.p.rapidapi.com/search/movie?query=".$name,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: advanced-movie-search.p.rapidapi.com",
                "X-RapidAPI-Key: a747e40327mshc551cd40fe4cc18p1ad2bajsnf2e00d187c17"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return response()->json([
                'message' => 'Curl Bağlantı Hatası : '. $err
            ], 500);
        }
        elseif ($response==null){
            return response()->json([
                'message' => 'Veri Bulunamadı'
            ], 404);
        } else {
            $data = array();
            $response = json_decode($response, true);
            foreach ($response['results'] as $resp) {

                $film = array();

                $json_str = '["' . $resp['original_title'] . '"]';
                $film['title'] = json_decode($json_str)[0];

                if ($resp['poster_path'] != null) {
                    $film['image'] =  $resp['poster_path'];
                } else {
                    $film['image'] = null;
                }

                $film['year'] = $resp['release_date'];
                array_push($data, $film);

            }

            $json_data = json_encode(['data' => $data], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);//Çince karakter problemine yakalanmamak için ve linklerdeki kaçış karakterleri
            return $json_data;

        }

    }


}
