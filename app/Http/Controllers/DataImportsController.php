<?php

namespace App\Http\Controllers;

use App\imports\CsvFileReader;

class DataImportsController extends Controller
{
    public function index()
    {

        $fileParse = new CsvFileReader("C:\Users\Bozo\Documents\personal\dataimporter\app\imports\sample_users.csv");
        $fileParse->parse();
        dd($fileParse->getData());
    }
}
