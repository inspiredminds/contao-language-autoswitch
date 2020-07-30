<?php

declare(strict_types=1);

/*
 * This file is part of the Automatic Language Switching Contao extension.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

use InspiredMinds\ContaoLanguageAutoswitch\Module\CalendarModule;
use InspiredMinds\ContaoLanguageAutoswitch\Module\CumulativeFilterModule;
use InspiredMinds\ContaoLanguageAutoswitch\Module\CustomnavModule;
use InspiredMinds\ContaoLanguageAutoswitch\Module\EventListModule;
use InspiredMinds\ContaoLanguageAutoswitch\Module\EventReaderModule;
use InspiredMinds\ContaoLanguageAutoswitch\Module\NavigationModule;
use InspiredMinds\ContaoLanguageAutoswitch\Module\NewsCategoriesModule;
use InspiredMinds\ContaoLanguageAutoswitch\Module\NewsListModule;
use InspiredMinds\ContaoLanguageAutoswitch\Module\NewsReaderModule;
use InspiredMinds\ContaoLanguageAutoswitch\Module\SearchModule;
use InspiredMinds\ContaoLanguageAutoswitch\Module\SiblingNavigationEventsModule;
use InspiredMinds\ContaoLanguageAutoswitch\Module\SiblingNavigationNewsModule;

$GLOBALS['FE_MOD']['navigationMenu']['customnav'] = CustomnavModule::class;
$GLOBALS['FE_MOD']['navigationMenu']['navigation'] = NavigationModule::class;
$GLOBALS['FE_MOD']['application']['search'] = SearchModule::class;

if (isset($GLOBALS['FE_MOD']['news']['newslist'])) {
    $GLOBALS['FE_MOD']['news']['newslist'] = NewsListModule::class;
}

if (isset($GLOBALS['FE_MOD']['news']['newsreader'])) {
    $GLOBALS['FE_MOD']['news']['newsreader'] = NewsReaderModule::class;
}

if (isset($GLOBALS['FE_MOD']['events']['calendar'])) {
    $GLOBALS['FE_MOD']['events']['calendar'] = CalendarModule::class;
}

if (isset($GLOBALS['FE_MOD']['events']['eventreader'])) {
    $GLOBALS['FE_MOD']['events']['calendar'] = EventReaderModule::class;
}

if (isset($GLOBALS['FE_MOD']['events']['eventlist'])) {
    $GLOBALS['FE_MOD']['events']['eventlist'] = EventListModule::class;
}

if (isset($GLOBALS['FE_MOD']['news']['newscategories'])) {
    $GLOBALS['FE_MOD']['news']['newscategories'] = NewsCategoriesModule::class;
}

if (isset($GLOBALS['FE_MOD']['news']['newscategories_cumulative'])) {
    $GLOBALS['FE_MOD']['news']['newscategories_cumulative'] = CumulativeFilterModule::class;
}

if (isset($GLOBALS['FE_MOD']['news']['sibling_navigation_news'])) {
    $GLOBALS['FE_MOD']['news']['sibling_navigation_news'] = SiblingNavigationNewsModule::class;
}

if (isset($GLOBALS['FE_MOD']['news']['sibling_navigation_news'])) {
    $GLOBALS['FE_MOD']['events']['sibling_navigation_events'] = SiblingNavigationEventsModule::class;
}
