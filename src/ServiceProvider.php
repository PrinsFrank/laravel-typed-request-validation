<?php
declare(strict_types=1);

namespace PrinsFrank\LaravelTypedRequestValidation;

use Illuminate\Contracts\Support\DeferrableProvider;
use PrinsFrank\LaravelTypedRequestValidation\Console\RequestMakeCommand;

class ServiceProvider extends \Illuminate\Support\ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->extend('command.request.make', function ($command, $app) {
            return new RequestMakeCommand($app['files']);
        });
    }

    /**
     * @return array<string|class-string>
     */
    public function provides(): array
    {
        return [
            'command.request.make'
        ];
    }
}
