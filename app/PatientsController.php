<?php

namespace App;

class PatientsController extends Controller
{

    public function index()
    {
        $response = [
            'action' => 'index',
            'status' => 'ok'
        ];
        echo json_encode($response);
    }

    public function get($patientId)
    {
        $response = [
            'action' => 'get',
            'status' => $patientId
        ];
        echo json_encode($response);
    }

    public function create()
    {
        $response = [
            'action' => 'create',
            'status' => 'created'
        ];
        echo json_encode($response);
    }

    public function update()
    {
        $response = [
            'action' => 'update',
            'status' => 'updated'
        ];
        echo json_encode($response);
    }

    public function delete()
    {
        $response = [
            'action' => 'delete',
            'status' => 'deleted'
        ];
        echo json_encode($response);
    }

}
