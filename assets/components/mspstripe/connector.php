<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var mspStripe $mspStripe */
$mspStripe = $modx->getService('mspStripe', 'mspStripe', MODX_CORE_PATH . 'components/mspstripe/model/');
$modx->lexicon->load('mspstripe:default');

// handle request
$corePath = $modx->getOption('mspstripe_core_path', null, $modx->getOption('core_path') . 'components/mspstripe/');
$path = $modx->getOption('processorsPath', $mspStripe->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest([
    'processors_path' => $path,
    'location' => '',
]);