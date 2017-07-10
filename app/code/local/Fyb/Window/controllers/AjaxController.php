<?php

class Fyb_Window_AjaxController extends Mage_Core_Controller_Front_Action
{
    public function GetAction()
    {
        $width = Mage::app()->getRequest()->getParam('width');
        $height = Mage::app()->getRequest()->getParam('height');
        $size = $width * $height;

        $collection = Mage::getModel('fybwindow/tier')->getCollection();

        $result = $collection
            ->addFieldToFilter('min_area_size', array('lteq' => $size))
            ->addFieldToFilter('max_area_size', array('gt' => $size))
            ->getFirstItem();


        $pricePerSquareMeter = $result->getData('price_per_square_meter');
        $finalPrice = $size * $pricePerSquareMeter;

        echo json_encode(
            array(
                'size' => $size,
                'price' => $finalPrice,
                'pricePerSquareMeter' => $pricePerSquareMeter
            )
        );

        return false;
    }
}
