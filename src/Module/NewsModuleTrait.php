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

use Contao\NewsArchiveModel;
use Contao\PageModel;
use Contao\StringUtil;
use Terminal42\ChangeLanguage\PageFinder;

trait NewsModuleTrait
{
    public function generate()
    {
        if (TL_MODE === 'BE') {
            return parent::generate();
        }

        $archives = StringUtil::deserialize($this->news_archives, true);

        if (empty($archives)) {
            return parent::generate();
        }

        // get the current language
        $currentLang = $GLOBALS['TL_LANGUAGE'];

        // get the page finder
        $pageFinder = new PageFinder();

        // go through each archive
        foreach ($archives as &$archiveId) {
            // load the archive
            $archive = NewsArchiveModel::findById($archiveId);

            if (null === $archive) {
                continue;
            }

            // load the target page
            $target = PageModel::findWithDetails($archive->jumpTo);

            // check if target language of the archive is not the current language
            if (null === $target || $target->rootLanguage === $currentLang) {
                continue;
            }

            // find the target page in the other language
            $otherPage = $pageFinder->findAssociatedForLanguage($target, $currentLang);

            if (null === $otherPage) {
                continue;
            }

            // find the other archive
            $t = NewsArchiveModel::getTable();
            $otherArchive = NewsArchiveModel::findBy([
                "$t.jumpTo = ?",
                "($t.master = ? OR $t.master = '0')",
            ], [
                $otherPage->id,
                0 !== (int) $archive->master ? (int) $archive->master : (int) $archive->id,
            ]);

            if (null !== $otherArchive) {
                $archiveId = $otherArchive->id;
            }
        }

        $this->news_archives = serialize(array_unique(array_filter($archives)));

        return parent::generate();
    }
}
