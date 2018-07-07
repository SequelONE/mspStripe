<?php

class mspStripeItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'mspStripeItem';
    public $classKey = 'mspStripeItem';
    public $languageTopics = ['mspstripe'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('mspstripe_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            $this->modx->error->addField('name', $this->modx->lexicon('mspstripe_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'mspStripeItemCreateProcessor';