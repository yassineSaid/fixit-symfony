<?php

namespace MainBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FosSf3MainBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}