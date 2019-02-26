<?php

namespace FosSf3\MainBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FosSf3MainBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}