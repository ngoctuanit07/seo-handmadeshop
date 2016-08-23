<?php

class Sns_Kalolia_Model_System_Config_Source_ListEffectImage
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'', 'label'=>Mage::helper('kalolia')->__('None')),
			array('value'=>'preserve-3d', 'label'=>Mage::helper('kalolia')->__('Preserve 3D')),
			array('value'=>'translatex', 'label'=>Mage::helper('kalolia')->__('Translate X')),
			array('value'=>'translatey', 'label'=>Mage::helper('kalolia')->__('Translate Y')),
			array('value'=>'transform-origin', 'label'=>Mage::helper('kalolia')->__('Transform Origin')),
		);
	}
}
