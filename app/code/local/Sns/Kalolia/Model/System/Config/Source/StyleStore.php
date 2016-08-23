<?php

class Sns_Kalolia_Model_System_Config_Source_StyleStore
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'style1', 'label'=>Mage::helper('kalolia')->__('Style1')),
			array('value'=>'style2', 'label'=>Mage::helper('kalolia')->__('Style2')),
		);
	}
}
