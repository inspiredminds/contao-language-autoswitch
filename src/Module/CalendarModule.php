<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch\Module;

use Contao\ModuleCalendar;

class CalendarModule extends ModuleCalendar
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
