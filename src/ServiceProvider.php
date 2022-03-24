<?php
declare(strict_types=1);

namespace PrinsFrank\LaravelTypedRequestValidation;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Routing\Redirector;
use PrinsFrank\LaravelTypedRequestValidation\Console\RequestMakeCommand;

class ServiceProvider extends \Illuminate\Support\ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->extend('command.request.make', function ($command, $app) {
            return new RequestMakeCommand($app['files']);
        });
    }

    public function boot(): void
    {
        $this->app->resolving(FormRequest::class, function ($request, $app) {
            $request = FormRequest::createFrom($app['request'], $request);

            $request->setContainer($app)->setRedirector($app->make(Redirector::class));
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
