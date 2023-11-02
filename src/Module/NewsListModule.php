<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch\Module;

use Codefog\NewsCategoriesBundle\FrontendModule\NewsListModule as NewsCategoriesNewsListModule;
use Contao\ModuleNewsList;

if (class_exists(NewsCategoriesNewsListModule::class)) {
    class ParentNewsListModule extends NewsCategoriesNewsListModule
    {
    }
} else {
    class ParentNewsListModule extends ModuleNewsList
    {
    }
}

class NewsListModule extends ParentNewsListModule
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
