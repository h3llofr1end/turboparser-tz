<?php

namespace tests\Unit\Helpers;

use App\Helpers\TextFunctions;
use App\Jobs\Invoker;
use App\Jobs\Receiver;
use App\Jobs\TextWorker;
use PHPUnit\Framework\TestCase;
use Prophecy\Exception\Doubler\MethodNotFoundException;

class TextFunctionsTest extends TestCase
{
    function test_if_no_methods_raise_exception()
    {
        $this->expectException(\DomainException::class);
        $invoker = new Invoker();
        $invoker->setCommand(new TextWorker(json_encode(['job' => ['text' => 'Hello, world!']]), new TextFunctions(), new Receiver()));
        $invoker->run();
    }

    function test_stripTags_with_tags()
    {
        $invoker = new Invoker();
        $receiver = new Receiver();
        $invoker->setCommand(new TextWorker(json_encode(['job' => ['text' => 'Hello, <b>world!</b>', 'methods' => ['stripTags']]]), new TextFunctions(), $receiver));
        $invoker->run();
        $this->assertEquals($receiver->getOutput(), json_encode(['text' => 'Hello, world!']));
    }

    function test_stripTags_without_tags()
    {
        $invoker = new Invoker();
        $receiver = new Receiver();
        $invoker->setCommand(new TextWorker(json_encode(['job' => ['text' => 'Hello, world!', 'methods' => ['stripTags']]]), new TextFunctions(), $receiver));
        $invoker->run();
        $this->assertEquals($receiver->getOutput(), json_encode(['text' => 'Hello, world!']));
    }

    function test_removeSpaces_with_spaces()
    {
        $invoker = new Invoker();
        $receiver = new Receiver();
        $invoker->setCommand(new TextWorker(json_encode(['job' => ['text' => 'Hello, world!', 'methods' => ['removeSpaces']]]), new TextFunctions(), $receiver));
        $invoker->run();
        $this->assertEquals($receiver->getOutput(), json_encode(['text' => 'Hello,world!']));
    }

    function test_removeSpaces_without_spaces()
    {
        $invoker = new Invoker();
        $receiver = new Receiver();
        $invoker->setCommand(new TextWorker(json_encode(['job' => ['text' => 'Hello,world!', 'methods' => ['removeSpaces']]]), new TextFunctions(), $receiver));
        $invoker->run();
        $this->assertEquals($receiver->getOutput(), json_encode(['text' => 'Hello,world!']));
    }

    function test_replaceSpacesToEol_with_spaces()
    {
        $invoker = new Invoker();
        $receiver = new Receiver();
        $invoker->setCommand(new TextWorker(json_encode(['job' => ['text' => 'Hello, world!', 'methods' => ['replaceSpacesToEol']]]), new TextFunctions(), $receiver));
        $invoker->run();
        $this->assertEquals($receiver->getOutput(), json_encode(['text' => "Hello,".PHP_EOL."world!"]));
    }

    function test_replaceSpacesToEol_without_spaces()
    {
        $invoker = new Invoker();
        $receiver = new Receiver();
        $invoker->setCommand(new TextWorker(json_encode(['job' => ['text' => 'Hello,world!', 'methods' => ['replaceSpacesToEol']]]), new TextFunctions(), $receiver));
        $invoker->run();
        $this->assertEquals($receiver->getOutput(), json_encode(['text' => "Hello,world!"]));
    }

    function test_toNumber_with_number_in_text()
    {
        $invoker = new Invoker();
        $receiver = new Receiver();
        $invoker->setCommand(new TextWorker(json_encode(['job' => ['text' => 'Hello, 10 year of 5th world!', 'methods' => ['toNumber']]]), new TextFunctions(), $receiver));
        $invoker->run();
        $this->assertEquals($receiver->getOutput(), json_encode(['text' => "10"]));
    }

    function test_toNumber_without_number_in_text()
    {
        $invoker = new Invoker();
        $receiver = new Receiver();
        $invoker->setCommand(new TextWorker(json_encode(['job' => ['text' => 'Hello, world!', 'methods' => ['toNumber']]]), new TextFunctions(), $receiver));
        $invoker->run();
        $this->assertEquals($receiver->getOutput(), json_encode(['text' => 0]));
    }

    function test_try_exec_non_exist_method_with_exist()
    {
        $invoker = new Invoker();
        $receiver = new Receiver();
        $invoker->setCommand(new TextWorker(json_encode(['job' => ['text' => 'Hello, world!', 'methods' => ['toNumber', 'otherMethod']]]), new TextFunctions(), $receiver));
        $invoker->run();
        $this->assertEquals($receiver->getOutput(), json_encode(['text' => 0]));
    }
}
