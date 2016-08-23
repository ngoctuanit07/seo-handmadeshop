<?php

class Sns_Kalolia_Model_System_Config_Source_ListResMenu
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'sidebar', 'label'=>Mage::helper('kalolia')->__('SideBar')),
			array('value'=>'collapse', 'label'=>Mage::helper('kalolia')->__('Collapse'))
		);
	}
}
