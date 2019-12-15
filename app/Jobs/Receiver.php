<?php

namespace App\Jobs;

class Receiver
{
    private $output = [];

    public function write(string $str)
    {
        $this->output[] = $str;
    }

    public function getOutput(): string
    {
        return join("\n", $this->output);
    }
}
