<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch\Module;

use InspiredMinds\ContaoSiblingNavigation\Module\SiblingNavigationEvents;

class SiblingNavigationEventsModule extends SiblingNavigationEvents
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
