<?php


namespace App\readers;


use App\readers\Exceptions\CSVException;

class CsvFileReader implements FileReaderInterface
{
    /**@var string */
    protected $file;

    /** @var array */
    protected $header;

    /** @var array data */
    protected $data;

    /**@var string */
    const FILE_EXTENSION = 'csv';

    /**
     * CsvFileParser constructor.
     * @param string $filePath the absolute file path
     */
    public function __construct(string $filePath)
    {
        $this->file = $filePath;
    }

    /**
     * @return bool
     */
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

    /**
     * @throws CSVException
     */
    public function readFile()
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

        $rows = [];
        try {
            $this->setHeader(fgetcsv($file));
            while ($row = fgetcsv($file)) {
                $record = $this->combineKeysAndValues($this->getHeader(), $row);
                $rows[] = $record;
            }
        } catch (\Exception $exception) {
            throw new CSVException(CSVException::ERROR_FAILED_TO_LOAD_DATA . $exception->getMessage());
        } finally {
            fclose($file);
        }

        $this->data = $rows;
    }

    public function combineKeysAndValues($keys, $fields, bool $addExtraFields = true)
    {
        $result = array();
        foreach ($keys as $i => $key) {
            $newKey = trim($key);
            $newField = isset($fields[$i]) ? trim($fields[$i]) : "";
            if (trim($newField) === "") {
                continue;
            }
            $result[$newKey] = $newField;
            unset($fields[$i]);
        }
        if ($addExtraFields === false) {
            return $result;
        }

        foreach ($fields as $index => $value) {
            if (trim($value) === "") {
                continue;
            }
            $key = trim($value);
            $result[$key] = trim($value);
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }

    /**
     * @param array $header
     */
    public function setHeader(array $header): void
    {
        $this->header = $header;
    }
}