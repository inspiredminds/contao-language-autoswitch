<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch\Module;

use InspiredMinds\ContaoSiblingNavigation\Module\SiblingNavigationNews;

class SiblingNavigationNewsModule extends SiblingNavigationNews
{
    use JumpToTrait;
    use NewsModuleTrait;

    public function generate()
    {
        $this->switchNewsArchives();
        $this->switchJumpTo();

        return parent::generate();
    }
}
