<?php

class Sns_Kalolia_Model_System_Config_Source_BgPosition
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'left top', 'label'=>Mage::helper('kalolia')->__('left top')),
			array('value'=>'left center', 'label'=>Mage::helper('kalolia')->__('left center')),
			array('value'=>'left bottom', 'label'=>Mage::helper('kalolia')->__('left bottom')),
			array('value'=>'right top', 'label'=>Mage::helper('kalolia')->__('right top')),
			array('value'=>'right center', 'label'=>Mage::helper('kalolia')->__('right center')),
			array('value'=>'right bottom', 'label'=>Mage::helper('kalolia')->__('right bottom')),
			array('value'=>'center top', 'label'=>Mage::helper('kalolia')->__('center top')),
			array('value'=>'center center', 'label'=>Mage::helper('kalolia')->__('center center')),
			array('value'=>'center bottom', 'label'=>Mage::helper('kalolia')->__('center bottom'))
		);
	}
}
