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

use Contao\CalendarModel;
use Contao\PageModel;
use Contao\StringUtil;
use Terminal42\ChangeLanguage\PageFinder;

trait EventModuleTrait
{
    public function generate()
    {
        if (TL_MODE === 'BE') {
            return parent::generate();
        }

        $calendars = StringUtil::deserialize($this->cal_calendar, true);

        if (empty($calendars)) {
            return parent::generate();
        }

        // get the current language
        $currentLang = $GLOBALS['TL_LANGUAGE'];

        // get the page finder
        $pageFinder = new PageFinder();

        // go through each calendar
        foreach ($calendars as &$calendarId) {
            // load the calendar
            $calendar = CalendarModel::findById($calendarId);

            if (null === $calendar) {
                continue;
            }

            // load the target page
            $target = PageModel::findWithDetails($calendar->jumpTo);

            // check if target language of the calendar is not the current language
            if (null === $target || $target->rootLanguage === $currentLang) {
                continue;
            }

            // find the target page in the other language
            $otherPage = $pageFinder->findAssociatedForLanguage($target, $currentLang);

            if (null === $otherPage) {
                continue;
            }

            // find the other calendar
            $t = CalendarModel::getTable();
            $otherCalendar = CalendarModel::findBy([
                "$t.jumpTo = ?",
                "($t.master = ? OR $t.master = '0')",
            ], [
                $otherPage->id,
                0 !== (int) $calendar->master ? (int) $calendar->master : (int) $calendar->id,
            ]);

            if (null !== $otherCalendar) {
                $calendarId = $otherCalendar->id;
            }
        }

        $this->cal_calendar = serialize(array_unique(array_filter($calendars)));

        return parent::generate();
    }
}
