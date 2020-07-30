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

class EventReaderModule extends \Contao\ModuleEventReader
{
    use EventModuleTrait;

    public function generate()
    {
        $this->switchCalendars();

        return parent::generate();
    }
}
