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
use Terminal42\ChangeLanguage\PageFinder;

trait JumpToTrait
{
    public function switchJumpTo(): void
    {
        if (TL_MODE === 'BE' || !$this->jumpTo) {
            return;
        }

        // get the current language
        $currentLang = $GLOBALS['TL_LANGUAGE'];

        // get the page finder
        $pageFinder = new PageFinder();

        // get the target page
        $target = PageModel::findWithDetails($this->jumpTo);

        // Check if target page is not in the current language
        if (null === $target || $target->rootLanguage === $currentLang) {
            return;
        }

        // get associated page for language
        if (null !== ($otherPage = $pageFinder->findAssociatedForLanguage($target, $currentLang))) {
            $this->objModel->jumpTo = $otherPage->id;
            $this->jumpTo = $otherPage->id;
        }
    }
}
