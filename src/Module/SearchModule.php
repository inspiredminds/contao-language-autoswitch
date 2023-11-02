<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch\Module;

use Contao\ModuleSearch;

class SearchModule extends ModuleSearch
{
    use JumpToTrait;

    public function generate()
    {
        $this->switchJumpTo();

        return parent::generate();
    }
}
