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
use Symfony\Component\HttpFoundation\RequestStack;
use Terminal42\ChangeLanguage\PageFinder;

class NewsCategoriesManager extends CodefogNewsCategoriesManager
{
    public function __construct(
        private readonly CodefogNewsCategoriesManager $inner,
        private readonly PageFinder $pageFinder,
        private readonly RequestStack $requestStack,
        protected ContaoFramework|null $framework,
    ) {
    }

    public function getTargetPage(NewsCategoryModel $category): PageModel|null
    {
        if (!$targetPage = $this->inner->getTargetPage($category)) {
            return null;
        }

        if (!$request = $this->requestStack->getCurrentRequest()) {
            return $targetPage;
        }

        try {
            return $this->pageFinder->findAssociatedForLanguage($targetPage, $request->getLocale());
        } catch (\Throwable) {
            return $targetPage;
        }
    }
}
