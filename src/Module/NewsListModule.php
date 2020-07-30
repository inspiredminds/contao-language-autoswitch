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

use Codefog\NewsCategoriesBundle\FrontendModule\NewsListModule as NewsCategoriesNewsListModule;

if (class_exists(NewsCategoriesNewsListModule::class)) {
    class ParentNewsListModule extends NewsCategoriesNewsListModule
    {
    }
} else {
    class ParentNewsListModule extends \Contao\ModuleNewsList
    {
    }
}

class NewsListModule extends ParentNewsListModule
{
    use NewsModuleTrait;
    use JumpToTrait;

    public function generate()
    {
        $this->switchNewsArchives();
        $this->switchJumpTo();

        return parent::generate();
    }
}
