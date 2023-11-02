<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch\Module;

use Contao\System;

trait ScopeTrait
{
    protected function isFrontendScope(): bool
    {
        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        return $request && System::getContainer()->get('contao.routing.scope_matcher')->isFrontendRequest($request);
    }
}
