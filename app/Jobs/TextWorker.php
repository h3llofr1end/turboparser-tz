<?php

namespace App\Jobs;

use App\Helpers\HelperFunctions;
use App\Helpers\TextFunctions;

// Pattern - Command | SOLID

class TextWorker implements Command
{
    private $json;
    private $helper;
    private $output;

    public function __construct(string $json, HelperFunctions $function, Receiver $receiver)
    {
        $this->json = $json;
        $this->helper = $function;
        $this->output = $receiver;
    }

    public function handle()
    {
        $data = json_decode($this->json);
        $result = '';

        if (!isset($data->job->text)) {
            throw new \DomainException("I don't have text for job");
        } else {
            $result = $data->job->text;
        }

        if (!isset($data->job->methods)) {
            throw new \DomainException('Don\'t have methods for job');
        }

        foreach ($data->job->methods as $method) {
            $cachedResult = $result;
            try {
                $result = $this->helper->call($method, $result);
            } catch (\Exception $e) {
                $result = $cachedResult;
            }
        }

        $this->output->write(json_encode(['text' => $result]));
    }
}
