<?php declare(strict_types = 1);

namespace DirkPersky\DpHttp2\Hooks;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use DirkPersky\DpHttp2\Utility\ResourceParser;

class ContentPostProcessor
{
    protected $typoScript;

    public function accumulateResources(array $params)
    {
        if(!$this->isEnabled()) return;
    }

    public function all(array $params, TypoScriptFrontendController $typoScriptFrontendController)
    {
        if(!$this->isEnabled()) return;
    }

    public function output(array $params, TypoScriptFrontendController $typoScriptFrontendController)
    {
        if(!$this->isEnabled()) return;
        // parse HTML for Preloads
        $preloads = ResourceParser::preloads($typoScriptFrontendController->content);
        // get Stylesheats from DOM
        $styles = ResourceParser::stylesheat($typoScriptFrontendController->content);
        // get JS from DOM
        $js = ResourceParser::javascript($typoScriptFrontendController->content);
    }

    protected function isEnabled(){
        // return is active
        return ($this->getConfig('plugin.dp_http2.settings.enabled') == 'true');
    }

    protected function getConfig($keys){
        // if not defined get get TypoScript
        if(!$this->typoScript) {
            // get ConfigManager
            $settings = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
            // Das komplette TypoScript holen
            $this->typoScript = $settings->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        }
        // value holder
        $value = $this->typoScript;
        // explode
        $loops = explode('.',$keys);
        // get config
        foreach ($loops as $index => $key){
            // get correct key
            if(($index+1) <  count($loops)) $key .= '.';
            // loop data
            if(isset($value[$key])){
                $value = $value[$key];
            } else {
                $value = null;
            }
        }
        // return set
        return $value;
    }
}