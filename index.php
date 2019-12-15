<?php

require __DIR__.'/vendor/autoload.php';

$json = json_encode([
    'job' => [
        'text' => "Привет, мне на <a href=\"test@test.ru\">test@test.ru</a> пришло приглашение встретиться, попить кофе с <strong>10%</strong> содержанием молока за <i>$5</i>, пойдем вместе!",
        'methods' => [
            "stripTags", "removeSpaces", "replaceSpacesToEol", "htmlspecialchars", "removeSymbols", "toNumber"
        ]
    ]
]);

$invoker = new \App\Jobs\Invoker();
$invoker->setCommand(new \App\Jobs\TextWorker($json, new \App\Helpers\TextFunctions(), new \App\Jobs\Receiver()));
$invoker->run();

