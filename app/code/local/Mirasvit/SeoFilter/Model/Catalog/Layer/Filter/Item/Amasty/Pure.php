<?php /* added automatically by conflict fixing tool */ if (Mage::getConfig()->getNode('modules/Amasty_Xlanding/active')) {
                class Mirasvit_SeoFilter_Model_Catalog_Layer_Filter_Item_Amasty_Pure extends Amasty_Xlanding_Model_Catalog_Layer_Filter_Item {}
            } else if (Mage::getConfig()->getNode('modules/Amasty_Shopby/active')) {
                class Mirasvit_SeoFilter_Model_Catalog_Layer_Filter_Item_Amasty_Pure extends Amasty_Shopby_Model_Catalog_Layer_Filter_Item {}
            } else { class Mirasvit_SeoFilter_Model_Catalog_Layer_Filter_Item_Amasty_Pure extends Mirasvit_SeoFilter_Model_Catalog_Layer_Filter_Item_Abstract {} } ?>