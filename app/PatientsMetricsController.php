<?php

namespace App;

class PatientsMetricsController extends Controller
{

    public function index($patientId)
    {
        echo json_encode("PatientsMetricsController patientId=$patientId, controller index");
    }

    public function get($patientId, $metricId)
    {
        echo json_encode("PatientsMetricsController patientId=$patientId, metricId=$metricId, controller get");
    }

    public function create()
    {
        echo json_encode('PatientsMetricsController controller create');
    }

    public function update()
    {
        echo json_encode('PatientsMetricsController controller update');
    }

    public function delete()
    {
        echo json_encode('PatientsMetricsController controller delete');
    }

}
