<?php

class Sns_Kalolia_Model_System_Config_Source_LessStatus
{
	public function toOptionArray() {
		return array(
			array('value'=>'0', 'label'=>Mage::helper('kalolia')->__('Only compile when don\'t have the css file')),
			array('value'=>'1', 'label'=>Mage::helper('kalolia')->__('Alway compile'))
		);
	}
}
