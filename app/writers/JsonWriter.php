<?php

namespace App\writers;

use App\Json\JsonableObjects\JsonableObjectFactory;
use App\writers\Exceptions\JsonFileWriterException;

class JsonWriter implements FileWriterInterface
{
    private $successfulOutputFileName = "sample_users_successful.json";
    private $ErrorsOutputFileName = "sample_users_errors.json";
    private $data;
    private $successfulInsertCount = 0;
    private $unsuccessFulInsertCount = 0;
    private $className;
    /**
     * @var JsonableObjectFactory
     */
    private $factory;

    /**
     * JsonWriter constructor.
     * @param array $data
     * @param $className
     * @param JsonableObjectFactory $factory
     */
    public function __construct(array $data, $className, JsonableObjectFactory $factory)
    {
        $this->data = $data;
        $this->className = $className;
        $this->factory = $factory;
    }

    /**
     * @param string $successfulOutputFileName
     * @return JsonWriter
     */
    public function setSuccessfulOutputFileName(string $successfulOutputFileName): JsonWriter
    {
        $this->successfulOutputFileName = $successfulOutputFileName;
        return $this;
    }

    /**
     * @return string
     */
    public function getErrorsOutputFileName(): string
    {
        return $this->ErrorsOutputFileName;
    }

    /**
     * @return string
     */
    public function getSuccessfulOutputFileName(): string
    {
        return $this->successfulOutputFileName;
    }

    /**
     * @param string $ErrorsOutputFileName
     * @return JsonWriter
     */
    public function setErrorsOutputFileName(string $ErrorsOutputFileName): JsonWriter
    {
        $this->ErrorsOutputFileName = $ErrorsOutputFileName;
        return $this;
    }

    public function write()
    {
        $validDataFile = fopen($this->getSuccessfulOutputFileName(), "a+");
        $inValidDataFile = fopen($this->getErrorsOutputFileName(), "a+");

        try {
            foreach ($this->data as $row) {
                $jsonableObject = $this->factory->create($this->className, $row);
                if ($jsonableObject->validate()) {
                    fwrite($validDataFile, $jsonableObject->toJson());
                    $this->successfulInsertCount++;
                } else {
                    fwrite($inValidDataFile, implode(', ', $row));
                    fwrite($inValidDataFile, PHP_EOL);
                    $this->unsuccessFulInsertCount++;
                }
            }
        } catch (\Exception $exception) {
            throw new JsonFileWriterException(JsonFileWriterException::ERROR_FAILED_TO_LOAD_DATA . $exception->getMessage());
        } finally {
            fclose($validDataFile);
            fclose($inValidDataFile);
        }

        return true;
    }


    /**
     * @return int
     */
    public
    function getSuccessfulInsertCount(): int
    {
        return $this->successfulInsertCount;
    }

    /**
     * @param int
     */
    public
    function getUnsuccessfulInsert()
    {
        $this->unsuccessFulInsertCount;
    }
}