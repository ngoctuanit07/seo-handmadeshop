<?php

class Sns_Kalolia_Model_System_Config_Source_ListLayout
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'1', 'label'=>Mage::helper('kalolia')->__('Full width')),
			array('value'=>'2', 'label'=>Mage::helper('kalolia')->__('Boxed')),
		);
	}
}
