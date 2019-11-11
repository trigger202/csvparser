<?php


namespace App\Json\JsonableObjects;


class JsonableObjectFactory
{
    /**
     * @param string $class jsonableobject class
     * @param array $data
     * @return mixed
     */
    public function create(string $class, array $data)
    {
        switch ($class) {
            case $class === User::class:
                return new User($data);
            case $class === Profile::class:
                return new Profile($data);
            default:
                return new User($data);
        }
    }
}