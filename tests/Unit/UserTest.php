<?php

namespace Tests\Unit;

use App\Json\JsonableObjects\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testRules()
    {
        $user = new User(['ali' => 'fareh']);
        $actual = $user->rules();
        $rules = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string|min:8',
            'Platforms' => 'in:ios,windows,android,web',
        ];
        $this->assertEquals($rules, $actual);

        $this->assertNotEquals(['name' => 'string'], $actual);
    }


}
