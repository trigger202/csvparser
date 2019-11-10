<?php

namespace App\Http\Controllers;

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

        $jsonWriter = new JsonWriter($data);

        dd($jsonWriter->write());
    }
}
