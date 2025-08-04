<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch\Module;

use Contao\CoreBundle\Util\LocaleUtil;
use Contao\NewsArchiveModel;
use Contao\PageModel;
use Contao\StringUtil;

trait NewsModuleTrait
{
    use ScopeTrait;

    public function switchNewsArchives(): void
    {
        if (!$this->isFrontendScope()) {
            return;
        }

        $archives = StringUtil::deserialize($this->news_archives, true);

        if (empty($archives)) {
            return;
        }

        // get the current language
        $currentLang = LocaleUtil::canonicalize($GLOBALS['TL_LANGUAGE']);

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

            // Get all suitable archives. We search for either the master, if
            // present, or the current ID (which means this is the master) and
            // we skip the current archive.
            $searchId = (int) ($archive->master ?: $archive->id);
            $t = NewsArchiveModel::getTable();
            $otherArchives = NewsArchiveModel::findBy(
                ["($t.id = ? OR $t.master = ?)", "$t.id != ?"],
                [$searchId, $searchId, (int) $archive->id],
            );

            // Check if archives have been found
            if (null === $otherArchives) {
                continue;
            }

            // Go through all archives
            foreach ($otherArchives as $otherArchive) {
                $otherPage = PageModel::findWithDetails($otherArchive->jumpTo);

                if (null === $otherPage) {
                    continue;
                }

                // Check if the target page language is the language we search for
                if ($otherPage->rootLanguage === $currentLang) {
                    $archiveId = $otherArchive->id;
                    break;
                }
            }
        }

        $this->news_archives = serialize(array_unique(array_filter($archives)));
    }
}
