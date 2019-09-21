<?php

namespace App;

class PatientsMetricsController extends Controller
{

    public function index($patientId)
    {
        $response = [
            'success' => true,
            'patientId' => $patientId
        ];
        echo json_encode($response);
    }

    public function get($patientId, $metricId)
    {
        $response = [
            'success' => true,
            'patientId' => $patientId,
            'metricId' => $metricId
        ];
        echo json_encode($response);
    }

    public function create($patientId)
    {
        $response = [
            'success' => true,
            'patientId' => $patientId
        ];
        echo json_encode($response);
    }

    public function update($patientId, $metricId)
    {
        $response = [
            'success' => true,
            'patientId' => $patientId,
            'metricId' => $metricId
        ];
        echo json_encode($response);
    }

    public function delete($patientId, $metricId)
    {
        $response = [
            'success' => true,
            'patientId' => $patientId,
            'metricId' => $metricId
        ];
        echo json_encode($response);
    }

}
