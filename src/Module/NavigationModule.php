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

use Contao\CoreBundle\Util\LocaleUtil;
use Contao\ModuleNavigation;
use Contao\PageModel;
use Terminal42\ChangeLanguage\PageFinder;

class NavigationModule extends ModuleNavigation
{
    public function generate()
    {
        if (TL_MODE === 'BE' || !$this->defineRoot || 0 === (int) $this->rootPage) {
            return parent::generate();
        }

        $rootPage = PageModel::findWithDetails($this->rootPage);
        $currentLang = $GLOBALS['TL_LANGUAGE'];

        if (class_exists(LocaleUtil::class)) {
            $currentLang = LocaleUtil::canonicalize($GLOBALS['TL_LANGUAGE']);
        }

        if (null === $rootPage || $rootPage->rootLanguage === $currentLang) {
            return parent::generate();
        }

        $pageFinder = new PageFinder();

        if (null !== ($otherPage = $pageFinder->findAssociatedForLanguage($rootPage, $currentLang))) {
            $this->rootPage = $otherPage->id;
        }

        return parent::generate();
    }
}
