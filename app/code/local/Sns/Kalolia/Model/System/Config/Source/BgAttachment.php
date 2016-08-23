<?php

class Sns_Kalolia_Model_System_Config_Source_BgAttachment
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'fixed', 'label'=>Mage::helper('kalolia')->__('fixed')),
			array('value'=>'scroll', 'label'=>Mage::helper('kalolia')->__('scroll'))
		);
	}
}
