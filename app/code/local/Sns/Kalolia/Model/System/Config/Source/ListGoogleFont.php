<?php

class Sns_Kalolia_Model_System_Config_Source_ListGoogleFont
{
	public function toOptionArray()
	{
		return array(
			array('value'=>'', 'label'=>Mage::helper('kalolia')->__('No select')),
			array('value'=>'Anton', 'label'=>Mage::helper('kalolia')->__('Anton')),
			array('value'=>'Roboto+Condensed', 'label'=>Mage::helper('kalolia')->__('Roboto Condensed')),
			array('value'=>'Port+Lligat+Slab', 'label'=>Mage::helper('kalolia')->__('Port Lligat Slab')),
			array('value'=>'Questrial', 'label'=>Mage::helper('kalolia')->__('Questrial')),
			array('value'=>'Kameron', 'label'=>Mage::helper('kalolia')->__('Kameron')),
			array('value'=>'Oswald', 'label'=>Mage::helper('kalolia')->__('Oswald')),
			array('value'=>'Open+Sans:300,400,600,700', 'label'=>Mage::helper('kalolia')->__('Open Sans')),
			array('value'=>'Open+Sans+Condensed:300,300italic,700', 'label'=>Mage::helper('kalolia')->__('Open Sans Condensed')),
			array('value'=>'BenchNine', 'label'=>Mage::helper('kalolia')->__('BenchNine')),
			array('value'=>'Droid Sans', 'label'=>Mage::helper('kalolia')->__('Droid Sans')),
			array('value'=>'Droid Serif', 'label'=>Mage::helper('kalolia')->__('Droid Serif')),
			array('value'=>'PT+Sans:400,700', 'label'=>Mage::helper('kalolia')->__('PT Sans')),
			array('value'=>'Vollkorn', 'label'=>Mage::helper('kalolia')->__('Vollkorn')),
			array('value'=>'Ubuntu', 'label'=>Mage::helper('kalolia')->__('Ubuntu')),
			array('value'=>'Neucha', 'label'=>Mage::helper('kalolia')->__('Neucha')),
			array('value'=>'Cuprum', 'label'=>Mage::helper('kalolia')->__('Cuprum')),
			array('value'=>'Passion+One:400,700', 'label'=>Mage::helper('kalolia')->__('Passion One')),
			array('value'=>'Roboto+Slab:400,700', 'label'=>Mage::helper('kalolia')->__('Roboto Slab'))
		);
	}
}
