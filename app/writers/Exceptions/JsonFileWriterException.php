<?php


namespace App\writers\Exceptions;


class JsonFileWriterException extends \Exception
{
    const ERROR_FAILED_TO_OPEN_FILE = "Error failed to open file %s";
    const ERROR_FILE_NOT_EXISTING = "File %s does not exist";
    const ERROR_FAILED_TO_LOAD_DATA = "Failed to load data from file";
    const ERROR_INVALID_FILE_EXTENSION = "Invalid file extension %s expected %s";
}