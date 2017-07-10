<?php

class Fyb_Window_Block_Form extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('fybwindow/form.phtml');
    }

    public function getFormAction()
    {
        return $this->getUrl('tiers/ajax/get');
    }
}
