<?php

class Sns_Kalolia_Model_System_Config_Source_ListColor
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'red', 'label'=>Mage::helper('kalolia')->__('Red')),
			array('value'=>'brown', 'label'=>Mage::helper('kalolia')->__('Brown')),
			array('value'=>'purple', 'label'=>Mage::helper('kalolia')->__('Purple')),
			array('value'=>'yellow', 'label'=>Mage::helper('kalolia')->__('Yellow')),
			array('value'=>'blue', 'label'=>Mage::helper('kalolia')->__('Blue')),
			array('value'=>'green', 'label'=>Mage::helper('kalolia')->__('Green')),
			array('value'=>'chocolate', 'label'=>Mage::helper('kalolia')->__('Chocolate')),
			array('value'=>'slateblue', 'label'=>Mage::helper('kalolia')->__('Slateblue')),
		);
	}
}
