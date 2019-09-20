<?php

namespace App;

class PatientsMetricsController
{

    public function index($patientId)
    {
        echo "PatientsMetricsController patientId=$patientId, controller index";
    }

    public function get($patientId, $metricId)
    {
        echo "PatientsMetricsController patientId=$patientId, metricId=$metricId, controller get";
    }

    public function create()
    {
        echo 'PatientsMetricsController controller create';
    }

    public function update()
    {
        echo 'PatientsMetricsController controller update';
    }

    public function delete()
    {
        echo 'PatientsMetricsController controller delete';
    }

}
