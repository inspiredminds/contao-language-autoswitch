<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch\Module;

use Contao\CoreBundle\Util\LocaleUtil;
use Contao\PageModel;
use Terminal42\ChangeLanguage\PageFinder;

trait JumpToTrait
{
    use ScopeTrait;

    public function switchJumpTo(string $field = 'jumpTo'): void
    {
        if (!$this->isFrontendScope() || !$this->{$field}) {
            return;
        }

        // get the current language
        $currentLang = $GLOBALS['TL_LANGUAGE'];

        if (class_exists(LocaleUtil::class)) {
            $currentLang = LocaleUtil::canonicalize($GLOBALS['TL_LANGUAGE']);
        }

        // get the page finder
        $pageFinder = new PageFinder();

        // get the target page
        $target = PageModel::findWithDetails($this->{$field});

        // Check if target page is not in the current language
        if (null === $target || $target->rootLanguage === $currentLang) {
            return;
        }

        // get associated page for language
        if ($otherPage = $pageFinder->findAssociatedForLanguage($target, $currentLang)) {
            $this->objModel->{$field} = $otherPage->id;
            $this->{$field} = $otherPage->id;
        }
    }
}
