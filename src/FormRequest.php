<?php
declare(strict_types=1);

namespace PrinsFrank\LaravelTypedRequestValidation;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use PrinsFrank\PhpStrictModels\WithValidatedProperties;

class FormRequest extends Request
{
    use WithValidatedProperties;

    protected Container $container;

    protected Redirector $redirector;

    protected string $redirect;

    protected string $redirectRoute;

    protected string $redirectAction;

    protected string $errorBag = 'default';

    protected bool $stopOnFirstFailure = false;

    protected function getRedirectUrl(): string
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->redirect) {
            return $url->to($this->redirect);
        }

        if ($this->redirectRoute) {
            return $url->route($this->redirectRoute);
        }

        if ($this->redirectAction) {
            return $url->action($this->redirectAction);
        }

        return $url->previous();
    }

    /**
     * @throws AuthorizationException
     */
    protected function passesAuthorization(): bool|Response
    {
        if (method_exists($this, 'authorize')) {
            $result = $this->container->call([$this, 'authorize']);

            return $result instanceof Response ? $result->authorize() : $result;
        }

        return true;
    }

    /**
     * @throws AuthorizationException
     */
    protected function failedAuthorization(): void
    {
        throw new AuthorizationException;
    }

    public function setRedirector(Redirector $redirector): static
    {
        $this->redirector = $redirector;

        return $this;
    }

    public function setContainer(Container $container): static
    {
        $this->container = $container;

        return $this;
    }
}
