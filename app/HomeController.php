<?php

namespace App;

class HomeController extends Controller
{

    public function home()
    {
        $response = [
            'action' => 'home',
            'status' => 'ok'
        ];
        echo json_encode($response);
    }

}
