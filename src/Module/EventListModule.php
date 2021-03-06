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

class EventListModule extends \Contao\ModuleEventlist
{
    use EventModuleTrait;
    use JumpToTrait;

    public function generate()
    {
        $this->switchCalendars();
        $this->switchJumpTo();

        return parent::generate();
    }
}
