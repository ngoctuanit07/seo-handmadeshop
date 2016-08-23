<?php

class Sns_Kalolia_Model_System_Config_Source_ListMenuStyles
{
	public function toOptionArray()
	{
		return array(
			//array('value'=>'base', 'label'=>Mage::helper('kalolia')->__('Base')),
			array('value'=>'mega', 'label'=>Mage::helper('kalolia')->__('Mega'))
		);
	}
}
