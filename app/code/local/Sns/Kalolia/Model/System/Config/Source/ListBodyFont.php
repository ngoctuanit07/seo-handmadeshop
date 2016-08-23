<?php
class Sns_Kalolia_Model_System_Config_Source_ListBodyFont
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'arial', 'label'=>Mage::helper('kalolia')->__('Arial')),
			array('value'=>'arial-black', 'label'=>Mage::helper('kalolia')->__('Arial black')),
			array('value'=>'courier new', 'label'=>Mage::helper('kalolia')->__('courier New')),
			array('value'=>'georgia', 'label'=>Mage::helper('kalolia')->__('Georgia')),
			array('value'=>'impact', 'label'=>Mage::helper('kalolia')->__('Impact')),
			array('value'=>'lucida-console', 'label'=>Mage::helper('kalolia')->__('Lucida Console')),
			array('value'=>'lucida-grande', 'label'=>Mage::helper('kalolia')->__('Lucida-grande')),
			array('value'=>'palatino', 'label'=>Mage::helper('kalolia')->__('Palatino')),
			array('value'=>'tahoma', 'label'=>Mage::helper('kalolia')->__('Tahoma')),
			array('value'=>'times new roman', 'label'=>Mage::helper('kalolia')->__('Times')),
			array('value'=>'Trebuchet', 'label'=>Mage::helper('kalolia')->__('Trebuchet')),
			array('value'=>'Verdana', 'label'=>Mage::helper('kalolia')->__('Verdana')),
			array('value'=>'segoe ui', 'label'=>Mage::helper('kalolia')->__('Segoe UI'))
		);
	}
}
