<?php

namespace App\Jobs;

use App\Helpers\TextFunctions;

class TextWorker
{
    public $json;
    public $result;

    public function __construct($json)
    {
        $this->json = $json;
    }

    public function handle()
    {
        $data = json_decode($this->json);

        if(!isset($data->job->text)) {
            throw new \DomainException("I don't have text for job");
        } else {
            $this->result = $data->job->text;
        }

        if(!isset($data->job->methods)) {
            throw new \DomainException('Don\'t have methods for job');
        }

        foreach($data->job->methods as $method)
        {
            if(method_exists(TextFunctions::class, $method)) {
                $this->result = TextFunctions::$method($this->result);
            } else {
                throw new \DomainException("Current method is not defined");
            }
        }

        return json_encode(['text' => $this->result]);
    }
}
