<?php

/**
 * The home manager controller for mspStripe.
 *
 */
class mspStripeHomeManagerController extends modExtraManagerController
{
    /** @var mspStripe $mspStripe */
    public $mspStripe;


    /**
     *
     */
    public function initialize()
    {
        $this->mspStripe = $this->modx->getService('mspStripe', 'mspStripe', MODX_CORE_PATH . 'components/mspstripe/model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['mspstripe:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('mspstripe');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->mspStripe->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->mspStripe->config['jsUrl'] . 'mgr/mspstripe.js');
        $this->addJavascript($this->mspStripe->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->mspStripe->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->mspStripe->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->mspStripe->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->mspStripe->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->mspStripe->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        mspStripe.config = ' . json_encode($this->mspStripe->config) . ';
        mspStripe.config.connector_url = "' . $this->mspStripe->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "mspstripe-page-home"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="mspstripe-panel-home-div"></div>';

        return '';
    }
}