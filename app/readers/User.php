<?php

namespace App\readers;

use Illuminate\Support\Facades\Validator;

class User
{
    private $rules = [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|string',
        'password' => 'required|string|min:8',
        'Platforms' => 'in:ios,windows,android,web',
    ];

    /**@var array */
    private $data;
    /**
     * @var Validator
     */
    private $validator;

    public function __construct(array $data)
    {
        $this->data = $this->convertToSnakeCase($data);

        $this->validator = Validator::make($this->data, $this->rules);
    }

    /**
     * @return array
     */
    public function validate()
    {
        return $this->validator->validate();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
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

    public function toJson()
    {
        return json_encode($this->data);
    }
}