<?php

namespace App\Json\JsonableObjects;

class User extends AbstractJsonableObject
{

    /**@inheritDoc */
    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string',
            'email' => 'required|string|regex:/user@domain\.com/i',
            'password' => 'required|string|min:8',
            'Platforms' => 'in:ios,windows,android,web',
        ];
    }
}