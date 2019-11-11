<?php


namespace App\Json\JsonableObjects;


class Profile extends AbstractJsonableObject
{
    /**
     * @return array
     */
    public function setRules()
    {
        return [
            'age' => 'required|int',
        ];
    }
}