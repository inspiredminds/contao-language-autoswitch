<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ContaoLanguageAutoswitch extends Bundle
{
    public function getPath()
    {
        return \dirname(__DIR__);
    }
}
