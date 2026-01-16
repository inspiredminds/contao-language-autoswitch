<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch;

use Codefog\NewsCategoriesBundle\Model\NewsCategoryModel;
use Codefog\NewsCategoriesBundle\NewsCategoriesManager as CodefogNewsCategoriesManager;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\PageModel;
use Symfony\Contracts\Translation\LocaleAwareInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Terminal42\ChangeLanguage\PageFinder;

class NewsCategoriesManager extends CodefogNewsCategoriesManager
{
    public function __construct(
        private readonly CodefogNewsCategoriesManager $inner,
        private readonly PageFinder $pageFinder,
        /**
         * @var TranslatorInterface&LocaleAwareInterface $translator
         */
        private readonly TranslatorInterface $translator,
        protected ContaoFramework|null $framework,
    ) {
    }

    public function getTargetPage(NewsCategoryModel $category): PageModel|null
    {
        if (!$targetPage = $this->inner->getTargetPage($category)) {
            return null;
        }

        return $this->pageFinder->findAssociatedForLanguage($targetPage, $this->translator->getLocale());
    }
}
