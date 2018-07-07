<?php

class mspStripeOfficeItemRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'mspStripeItem';
    public $classKey = 'mspStripeItem';
    public $languageTopics = ['mspstripe'];
    //public $permission = 'remove';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('mspstripe_item_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var mspStripeItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('mspstripe_item_err_nf'));
            }

            $object->remove();
        }

        return $this->success();
    }

}

return 'mspStripeOfficeItemRemoveProcessor';