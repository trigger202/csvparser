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
    /**
     * @var JsonableObjectFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    private $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = [['ali' => 'fareh', 'role' => 'developer']];
        $this->factory = $this->createMock(JsonableObjectFactory::class);
        $this->jsonWriter = new JsonWriter($this->data, User::class, $this->factory);
    }

    public function testWriteWithGoodDataMustReturnZeroFailedInserts()
    {
        $user = $this->createMock(User::class);

        $this->factory->expects($this->once())
            ->method('create')
            ->willReturn($user);
        $user->expects($this->once())->method('validate')->willReturn(true);

        $this->jsonWriter->write();

        $this->assertEquals(1, $this->jsonWriter->getSuccessfulInsertCount());
        $this->assertEquals(0, $this->jsonWriter->getUnsuccessfulInsert());
        @unlink($this->jsonWriter->getSuccessfulOutputFileName());
        @unlink($this->jsonWriter->getErrorsOutputFileName());
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
