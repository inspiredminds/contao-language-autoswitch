<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch\Module;

use Contao\CalendarModel;
use Contao\CoreBundle\Util\LocaleUtil;
use Contao\PageModel;
use Contao\StringUtil;

trait EventModuleTrait
{
    use ScopeTrait;

    public function switchCalendars(): void
    {
        if (!$this->isFrontendScope()) {
            return;
        }

        $calendars = StringUtil::deserialize($this->cal_calendar, true);

        if (empty($calendars)) {
            return;
        }

        // get the current language
        $currentLang = LocaleUtil::canonicalize($GLOBALS['TL_LANGUAGE']);

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

            // Get all suitable calendars. We search for either the master, if
            // present, or the current ID (which means this is the master) and
            // we skip the current calendar.
            $searchId = (int) ($calendar->master ?: $calendar->id);
            $t = CalendarModel::getTable();
            $otherCalendars = CalendarModel::findBy(
                ["($t.id = ? OR $t.master = ?)", "$t.id != ?"],
                [$searchId, $searchId, (int) $calendar->id],
            );

            // Check if calendars have been found
            if (null === $otherCalendars) {
                continue;
            }

            // Go through all calendars
            foreach ($otherCalendars as $otherCalendar) {
                $otherPage = PageModel::findWithDetails($otherCalendar->jumpTo);

                if (null === $otherPage) {
                    continue;
                }

                // Check if the target page language is the language we search for
                if ($otherPage->rootLanguage === $currentLang) {
                    $calendarId = $otherCalendar->id;
                    break;
                }
            }
        }

        $this->cal_calendar = serialize(array_unique(array_filter($calendars)));
    }
}
