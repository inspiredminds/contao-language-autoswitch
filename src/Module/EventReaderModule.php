<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch\Module;

use Contao\ModuleEventReader;

class EventReaderModule extends ModuleEventReader
{
    use EventModuleTrait;

    public function generate()
    {
        $this->switchCalendars();

        return parent::generate();
    }
}
