<?php
declare(strict_types=1);

namespace PrinsFrank\LaravelTypedRequestValidation\Console;

class RequestMakeCommand extends \Illuminate\Foundation\Console\RequestMakeCommand
{
    protected function getStub()
    {
        return __DIR__ . '/stubs/request.stub';
    }
}
