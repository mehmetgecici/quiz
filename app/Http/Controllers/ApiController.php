<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getApi(){


        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://moviesdatabase.p.rapidapi.com/titles/search/keyword/fast",
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
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }

    }
}
