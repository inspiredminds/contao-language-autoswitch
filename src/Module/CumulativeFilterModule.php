<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch\Module;

class CumulativeFilterModule extends \Codefog\NewsCategoriesBundle\FrontendModule\CumulativeFilterModule
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
