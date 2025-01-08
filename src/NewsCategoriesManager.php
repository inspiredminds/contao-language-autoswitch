<?php

declare(strict_types=1);

/*
 * (c) INSPIRED MINDS
 */

namespace InspiredMinds\ContaoLanguageAutoswitch;

use Codefog\NewsCategoriesBundle\Model\NewsCategoryModel;
use Codefog\NewsCategoriesBundle\NewsCategoriesManager as NewsCategoriesBundleNewsCategoriesManager;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\PageModel;
use Symfony\Component\HttpFoundation\RequestStack;
use Terminal42\ChangeLanguage\PageFinder;

class NewsCategoriesManager extends NewsCategoriesBundleNewsCategoriesManager
{
    public function __construct(
        private readonly PageFinder $pageFinder,
        private readonly RequestStack $requestStack,
        protected ContaoFramework|null $framework,
    ) {
    }

    public function getTargetPage(NewsCategoryModel $category): PageModel|null
    {
        if (!$targetPage = parent::getTargetPage($category)) {
            return $targetPage;
        }

        $request = $this->requestStack->getCurrentRequest();

        if ($request && ($otherPage = $this->pageFinder->findAssociatedForLanguage($targetPage, $request->getLocale()))) {
            return $otherPage;
        }

        return $targetPage;
    }
}
