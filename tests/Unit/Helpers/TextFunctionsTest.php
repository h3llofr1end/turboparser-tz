<?php

namespace tests\Unit\Helpers;

use App\Jobs\TextWorker;
use PHPUnit\Framework\TestCase;

class TextFunctionsTest extends TestCase
{
    function test_if_no_methods_raise_exception()
    {
        $this->expectException(\DomainException::class);
        $job = new TextWorker(json_encode(['job' => ['text' => 'Hello, world!']]));
        $result = $job->handle();
    }

    function test_stripTags_with_tags()
    {
        $job = new TextWorker(json_encode(['job' => ['text' => 'Hello, <b>world!</b>', 'methods' => ['stripTags']]]));
        $result = $job->handle();
        $this->assertEquals($result, json_encode(['text' => 'Hello, world!']));
    }

    function test_stripTags_without_tags()
    {
        $job = new TextWorker(json_encode(['job' => ['text' => 'Hello, world!', 'methods' => ['stripTags']]]));
        $result = $job->handle();
        $this->assertEquals($result, json_encode(['text' => 'Hello, world!']));
    }

    function test_removeSpaces_with_spaces()
    {
        $job = new TextWorker(json_encode(['job' => ['text' => 'Hello, world!', 'methods' => ['removeSpaces']]]));
        $result = $job->handle();
        $this->assertEquals($result, json_encode(['text' => 'Hello,world!']));
    }

    function test_removeSpaces_without_spaces()
    {
        $job = new TextWorker(json_encode(['job' => ['text' => 'Hello,world!', 'methods' => ['removeSpaces']]]));
        $result = $job->handle();
        $this->assertEquals($result, json_encode(['text' => 'Hello,world!']));
    }

    function test_replaceSpacesToEol_with_spaces()
    {
        $job = new TextWorker(json_encode(['job' => ['text' => 'Hello, world!', 'methods' => ['replaceSpacesToEol']]]));
        $result = $job->handle();
        $this->assertEquals($result, json_encode(['text' => "Hello,".PHP_EOL."world!"]));
    }

    function test_replaceSpacesToEol_without_spaces()
    {
        $job = new TextWorker(json_encode(['job' => ['text' => 'Hello,world!', 'methods' => ['replaceSpacesToEol']]]));
        $result = $job->handle();
        $this->assertEquals($result, json_encode(['text' => "Hello,world!"]));
    }

    function test_toNumber_with_number_in_text()
    {
        $job = new TextWorker(json_encode(['job' => ['text' => 'Hello, 10 year of 5th world!', 'methods' => ['toNumber']]]));
        $result = $job->handle();
        $this->assertEquals($result, json_encode(['text' => "10"]));
    }

    function test_toNumber_without_number_in_text()
    {
        $job = new TextWorker(json_encode(['job' => ['text' => 'Hello, world!', 'methods' => ['toNumber']]]));
        $result = $job->handle();
        $this->assertEquals($result, json_encode(['text' => 0]));
    }
}
