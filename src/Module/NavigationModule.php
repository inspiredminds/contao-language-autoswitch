<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch\Module;

use Contao\CoreBundle\Util\LocaleUtil;
use Contao\ModuleNavigation;
use Contao\PageModel;
use Terminal42\ChangeLanguage\PageFinder;

class NavigationModule extends ModuleNavigation
{
    use ScopeTrait;

    public function generate()
    {
        if (!$this->isFrontendScope() || !$this->defineRoot || 0 === (int) $this->rootPage) {
            return parent::generate();
        }

        $rootPage = PageModel::findWithDetails($this->rootPage);
        $currentLang = LocaleUtil::canonicalize($GLOBALS['TL_LANGUAGE']);

        if (null === $rootPage || $rootPage->rootLanguage === $currentLang) {
            return parent::generate();
        }

        $pageFinder = new PageFinder();

        if ($otherPage = $pageFinder->findAssociatedForLanguage($rootPage, $currentLang)) {
            $this->rootPage = $otherPage->id;
        }

        return parent::generate();
    }
}
