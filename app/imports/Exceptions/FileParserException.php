<?php


namespace App\imports\Exceptions;


class FileParserException extends \Exception
{
    const ERROR_FAILED_TO_OPEN_FILE = "ERROR_FAILED_TO_OPEN_FILE %s";
    const ERROR_FILE_NOT_EXISTING = "File %s does not exist";
    const ERROR_FAILED_TO_LOAD_DATA = "Failed to load data from file";
    const ERROR_INVALID_FILE_EXTENSION = "Invalid file extension %s expected %s";
}