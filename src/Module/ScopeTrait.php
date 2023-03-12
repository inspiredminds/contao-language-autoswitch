<?php

declare(strict_types=1);

/*
 * This file is part of the Automatic Language Switching Contao extension.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
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
