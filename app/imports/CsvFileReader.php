<?php


namespace App\imports;


use App\imports\Exceptions\CSVException;

class CsvFileReader implements FileReaderInterface
{
    /**@var string */
    protected $file;

    /** @var array */
    protected $header;

    /** @var array data */
    protected $data;

    /** @var User[] invalidData */
    private $invalidData;

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
    public function parse()
    {
        $this->readFile();
    }

    /**
     * @throws CSVException
     */
    private function readFile()
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

            $header = fgetcsv($file);
            while ($row = fgetcsv($file)) {
                $record = $this->combineKeysAndValues($header, $row);
                try {
                    $user = new User($record);
                    dump($user->toJson());
                    if ($user->validate()) {
                        $rows[] = $record;
                    }

                } catch (\Exception  $e) {
                    dump($e);
                    $this->invalidData[] = $row;
                }
            }
        } catch (\Exception $exception) {
            throw new CSVException(CSVException::ERROR_FAILED_TO_LOAD_DATA . $exception->getMessage());
        }
        fclose($file);

        $this->data = $rows;
    }

    public function combineKeysAndValues($keys, $fields, bool $addExtraFields = true)
    {
        $result = array();
        foreach ($keys as $i => $key) {
            $key = trim($key);
            $result[$key] = trim($fields[$i]);
            unset($fields[$i]);
        }

        if ($addExtraFields === false) {
            return $result;
        }
        foreach ($fields as $index => $value) {
            $key = trim($value);
            $result[$key] = trim($value);
        }

        return $result;
    }

    public function convertToSnakeCase($key)
    {
        return trim(strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $key)));
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

    /**
     * @return array
     */
    public function getInvalidData(): array
    {
        return $this->invalidData;
    }
}