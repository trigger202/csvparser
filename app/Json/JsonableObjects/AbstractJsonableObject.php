<?php


namespace App\Json\JsonableObjects;


use Illuminate\Support\Facades\Validator;

abstract class AbstractJsonableObject implements JsonableObjectInterface
{
    /**@var array */
    private $data;
    /**
     * @var Validator
     */
    private $validator;

    public function __construct(array $data)
    {
        $this->data = $this->convertToSnakeCase($data);

        $this->validator = Validator::make($this->data, $this->setRules());
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    abstract public function setRules();


    /**
     * @return bool
     */
    public function validate()
    {
        try {
            $this->validator->validate();
            return true;
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }

    public function convertToSnakeCase($data)
    {
        $snakeCaseData = [];
        foreach ($data as $key => $value) {
            $key = trim(preg_replace('/\s+/', '_', strtolower($key)));
            $snakeCaseData[$key] = $value;
        }
        return $snakeCaseData;
    }
}