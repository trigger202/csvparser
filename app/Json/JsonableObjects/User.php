<?php

namespace App\Json\JsonableObjects;

class User extends AbstractJsonableObject
{

    /**@inheritDoc */
    public function setRules()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string|min:8',
            'Platforms' => 'in:ios,windows,android,web',
        ];
    }
}