<?php


namespace App\Json\JsonableObjects;


class Profile extends AbstractJsonableObject
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'age' => 'required|int',
        ];
    }
}