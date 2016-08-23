<?php

class Sns_Kalolia_Model_System_Config_Source_BgRepeat
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'no-repeat', 'label'=>Mage::helper('kalolia')->__('no-repeat')),
			array('value'=>'repeat', 'label'=>Mage::helper('kalolia')->__('repeat')),
			array('value'=>'repeat-x', 'label'=>Mage::helper('kalolia')->__('repeat-x')),
			array('value'=>'repeat-y', 'label'=>Mage::helper('kalolia')->__('repeat-y'))
		);
	}
}
