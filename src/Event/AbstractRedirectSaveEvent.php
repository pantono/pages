<?php

namespace Pantono\Pages\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Pantono\Pages\Model\Redirect;

abstract class AbstractRedirectSaveEvent extends Event
{
    private Redirect $redirect;

    public function getRedirect(): Redirect
    {
        return $this->redirect;
    }

    public function setRedirect(Redirect $redirect): void
    {
        $this->redirect = $redirect;
    }
}
