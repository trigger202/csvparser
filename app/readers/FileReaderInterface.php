<?php


namespace App\readers;


interface FileReaderInterface
{
    public function readFile();

    public function setData($data);

    public function getData();

    public function isValidFile();
}