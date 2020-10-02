<?php declare(strict_types = 1);

namespace DirkPersky\DpHttp2\Hooks;
 use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class ContentPostProcessor
{
    public function output()
    {
        var_dump('output');
        die('output');
    }

    public function all()
    {
        var_dump('all');
        die('all');
    }

    public function accumulateResources()
    {
        var_dump('accumulateResources');
        die('accumulateResources');
    }

}