<?php


namespace App\imports;


use App\imports\Exceptions\CSVException;

class CsvImport implements FileParserInterface
{
    /** @var string */
    protected $file;

    /** @var array */
    protected $header;

    /** @var array data */
    protected $data;

    const FILE_EXTENSION = 'csv';


    public function __construct(string $filePath)
    {
        $this->file = $filePath;
    }

    public function isValidFile()
    {
        $parts = pathinfo($this->file);
        if (isset($parts['extension']) === false) {
            return false;
        }

        if (strtolower($parts['extension']) === self::FILE_EXTENSION) {
            return true;
        }

        return false;
    }

    public function parse()
    {
        if (!file_exists($this->file)) {
            throw new CSVException(sprintf(CSVException::ERROR_FILE_NOT_EXISTING, $this->file));
        }

        if (!$this->isValidFile()) {
            throw new CSVException(
                sprintf(CSVException::ERROR_INVALID_FILE_EXTENSION, $this->file, self::FILE_EXTENSION)
            );
        }

        $file = fopen($this->file, "r");
        if (!$file) {
            throw new CSVException(sprintf(CSVException::ERROR_FAILED_TO_OPEN_FILE, $this->file));
        }

        $data = [];
        try {

            while ($row = fgetcsv($file)) {
                $data[] = $row;
            }
        } catch (\Exception $exception) {
            throw new CSVException(CSVException::ERROR_FAILED_TO_LOAD_DATA . $exception->getMessage());
        }
        fclose($file);

        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }
}