<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SayacController extends Controller
{
    public function ekle() {
        $data = [
            'mukellefler' => [],
            'aboneTurleri' => [],
        ];

        return view('sayaclar.sayacEkle', $data);
    }
}
