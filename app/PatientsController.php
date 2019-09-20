<?php

namespace App;

class PatientsController
{

    public function index()
    {
        echo 'Patients controller index';
    }

    public function get($patientId)
    {
        echo "PatientsController get patientId = $patientId";
    }

    public function create()
    {
        echo 'Patients controller create';
    }

    public function update()
    {
        echo 'Patients controller update';
    }

    public function delete()
    {
        echo 'Patients controller delete';
    }

}
