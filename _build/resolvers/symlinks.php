<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/mspStripe/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/mspstripe')) {
            $cache->deleteTree(
                $dev . 'assets/components/mspstripe/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/mspstripe/', $dev . 'assets/components/mspstripe');
        }
        if (!is_link($dev . 'core/components/mspstripe')) {
            $cache->deleteTree(
                $dev . 'core/components/mspstripe/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/mspstripe/', $dev . 'core/components/mspstripe');
        }
    }
}

return true;