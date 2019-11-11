<?php

namespace Tests\Unit;

use App\Json\JsonableObjects\JsonableObjectFactory;
use App\Json\JsonableObjects\Profile;
use App\Json\JsonableObjects\User;
use Tests\TestCase;

class JsonableObjectFactoryTest extends TestCase
{
    public function testCreateFactoryCreatesCorrectObject()
    {
        $factory = new JsonableObjectFactory();

        $userClass = $factory->create(User::class, ['abc' => 'adf']);

        $this->assertInstanceOf(User::class, $userClass);

        $profileClass = $factory->create(Profile::class, ['abc' => 'adf']);

        $this->assertInstanceOf(Profile::class, $profileClass);
    }
}
