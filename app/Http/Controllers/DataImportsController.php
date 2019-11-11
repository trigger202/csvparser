<?php

namespace App\Http\Controllers;

use App\Json\JsonableObjects\JsonableObjectFactory;
use App\Json\JsonableObjects\User;
use App\readers\CsvFileReader;
use App\writers\JsonWriter;

class DataImportsController extends Controller
{
    public function index()
    {
        $csvReader = new CsvFileReader(
            "C:\Users\Bozo\Documents\personal\dataimporter\app\\readers\sample_users.csv");
        $csvReader->readFile();
        $data = $csvReader->getData();
        $jsonWriter = new JsonWriter($data, User::class, new JsonableObjectFactory());

        $jsonWriter->write();

        dd($jsonWriter);
    }
}
