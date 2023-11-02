<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch\Module;

use Contao\ModuleEventlist;

class EventListModule extends ModuleEventlist
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
