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

use Contao\PageModel;
use Contao\StringUtil;

class CustomnavModule extends \Contao\ModuleCustomnav
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
        $pageFinder = new \Terminal42\ChangeLanguage\PageFinder();

        foreach ($pages as &$pageId) {
            // load the page
            $page = PageModel::findWithDetails($pageId);

            // check if page language is not the current language
            if (null === $page || $page->rootLanguage === $currentLang) {
                continue;
            }

            // find pendant in current language
            if (null !== ($otherPage = $pageFinder->findAssociatedForLanguage($page, $currentLang))) {
                $pageId = $otherPage->id;
            }
        }

        $this->pages = serialize($pages);

        return parent::generate();
    }
}
