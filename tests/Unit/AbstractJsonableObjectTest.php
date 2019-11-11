<?php

namespace Tests\Unit;

use App\Json\JsonableObjects\User;
use Tests\TestCase;

class AbstractJsonableObjectTest extends TestCase
{
    /**
     * @var User
     */
    private $user;

    private $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'first_name' => 'ali',
            'last_name' => 'fareh',
        ];

        $this->user = new User($this->data);
    }

    public function testGetDataReturnsSnakeCasedDataArray()
    {
        $this->assertIsArray($this->user->getData());
        $this->assertEquals($this->data, $this->user->getData());
    }

    public function testToJson()
    {
        $json = '{"first_name":"ali","last_name":"fareh"}';
        $this->assertEquals($json, $this->user->toJson());
        $this->assertEquals(json_decode($json, true), json_decode($this->user->toJson(), true));
    }
    /*Todo*/
    /*
     *     public function testValidate()
        {
            $validator = $this->createMock(\stdClass::class);

            $user = $this->getMockBuilder(User::class)
                ->setConstructorArgs([$this->data, $validator])
                ->setMethodsExcept(['validate', 'setValidator'])
                ->getMock();

            $validator->expects($this->once())->method('validate');

            $user->validate();
        }*/

    public function testConvertToSnakeCase()
    {
        $expected = [
            'firest_name' => 'ali',
            'last_name' => 'fareh',
        ];

        $data = [
            'firest name' => 'ali',
            'last name' => 'fareh',
        ];

        $this->assertEquals($expected, $this->user->convertToSnakeCase($data));
    }
}
