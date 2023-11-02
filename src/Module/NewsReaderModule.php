<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch\Module;

use Contao\ModuleNewsReader;

class NewsReaderModule extends ModuleNewsReader
{
    use JumpToTrait;
    use NewsModuleTrait;

    public function generate()
    {
        $this->switchNewsArchives();
        $this->switchJumpTo('overviewPage');

        return parent::generate();
    }
}
