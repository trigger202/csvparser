<?php

namespace Tests\Unit;

use App\Json\JsonableObjects\JsonableObjectFactory;
use App\Json\JsonableObjects\User;
use App\writers\JsonWriter;
use Tests\TestCase;

class JsonWriterTest extends TestCase
{
    private $data;
    /**
     * @var JsonWriter
     */
    private $jsonWriter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = ['ali' => 'fareh', 'role' => 'developer'];

        $this->jsonWriter = new JsonWriter($this->data, User::class, $this->createMock(JsonableObjectFactory::class));
    }

    public function testGetAndSetSuccessfulOutputFileName()
    {
        $test = "successful.json";
        $this->jsonWriter->setSuccessfulOutputFileName($test);
        $this->assertEquals($test, $this->jsonWriter->getSuccessfulOutputFileName());
    }

    public function testGetAndSetErrorsOutputFileName()
    {
        $test = "errors.json";
        $this->jsonWriter->setErrorsOutputFileName($test);
        $this->assertEquals($test, $this->jsonWriter->getErrorsOutputFileName());
    }

    public function testGetSuccessfulInsertCount()
    {
        $this->assertEquals(0, $this->jsonWriter->getSuccessfulInsertCount());
    }

    public function testGetUnsuccessfulInsert()
    {
        $this->assertEquals(0, $this->jsonWriter->getUnsuccessfulInsert());
    }
}
