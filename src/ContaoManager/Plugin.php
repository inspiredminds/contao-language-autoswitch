<?php

declare(strict_types=1);

/*
 * This file is part of the Automatic Language Switching Contao extension.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoLanguageAutoswitch\ContaoManager;

use Codefog\NewsCategoriesBundle\CodefogNewsCategoriesBundle;
use Contao\CalendarBundle\ContaoCalendarBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\NewsBundle\ContaoNewsBundle;
use InspiredMinds\ContaoLanguageAutoswitch\ContaoLanguageAutoswitch;
use InspiredMinds\ContaoSiblingNavigation\ContaoSiblingNavigationBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(ContaoLanguageAutoswitch::class)
                ->setLoadAfter([
                    ContaoCoreBundle::class,
                    ContaoNewsBundle::class,
                    ContaoCalendarBundle::class,
                    CodefogNewsCategoriesBundle::class,
                    ContaoSiblingNavigationBundle::class,
                ]),
        ];
    }
}
