<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch\Module;

use Contao\ModuleCustomnav;
use Contao\PageModel;
use Contao\StringUtil;
use Terminal42\ChangeLanguage\PageFinder;

class CustomnavModule extends ModuleCustomnav
{
    use ScopeTrait;

    public function generate()
    {
        if (!$this->isFrontendScope()) {
            return parent::generate();
        }

        $pages = StringUtil::deserialize($this->pages, true);

        // get the current language
        $currentLang = $GLOBALS['TL_LANGUAGE'];

        // get the page finder
        $pageFinder = new PageFinder();

        foreach ($pages as &$pageId) {
            // load the page
            $page = PageModel::findWithDetails($pageId);

            // check if page language is not the current language
            if (null === $page || $page->rootLanguage === $currentLang) {
                continue;
            }

            // find pendant in current language
            if ($otherPage = $pageFinder->findAssociatedForLanguage($page, $currentLang)) {
                $pageId = $otherPage->id;
            }
        }

        $this->pages = serialize($pages);

        return parent::generate();
    }
}
