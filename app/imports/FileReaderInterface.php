<?php


namespace App\imports;


interface FileReaderInterface
{
    public function parse();

    public function setData($data);

    public function getData();

    public function isValidFile();
}