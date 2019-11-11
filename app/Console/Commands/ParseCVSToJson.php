<?php

namespace App\Console\Commands;

use App\Json\JsonableObjects\JsonableObjectFactory;
use App\Json\JsonableObjects\User;
use App\readers\CsvFileReader;
use App\writers\JsonWriter;
use Illuminate\Console\Command;

class ParseCVSToJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:json {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Takes CSV file as argument and parses that to json file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \App\readers\Exceptions\CSVException
     * @throws \App\writers\Exceptions\JsonFileWriterException
     */
    public function handle()
    {
        $filePath = $this->argument('file');

        if (file_exists($filePath) === false) {
            $this->error("File does not exist " . $filePath);
            exit();
        }

        try {
            $csvReader = new CsvFileReader($filePath);
            $csvReader->readFile();
            $data = $csvReader->getData();
            $jsonWriter = new JsonWriter($data, User::class, new JsonableObjectFactory());
            $jsonWriter->write();
            $this->info("Total successful inserts " . $jsonWriter->getSuccessfulInsertCount());
            $this->info("Total errors " . $jsonWriter->getUnsuccessfulInsert());
            $this->info("Please see " . $jsonWriter->getSuccessfulOutputFileName());
            $this->info("Total errors " . $jsonWriter->getUnsuccessfulInsert());
        } catch (\Exception $e) {
            $this->error("Woops something went wrong while parsing the file");
        }


    }
}
