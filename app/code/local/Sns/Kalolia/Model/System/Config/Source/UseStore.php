<?php

class Sns_Kalolia_Model_System_Config_Source_UseStore {
	public function toOptionArray()
	{
		return array(
			array('value'=>'light', 'label'=>Mage::helper('kalolia')->__('Light')),
			array('value'=>'dark', 'label'=>Mage::helper('kalolia')->__('Dark'))
		);
	}
}