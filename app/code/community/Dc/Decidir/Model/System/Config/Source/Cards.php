<?php
/**
 * Dc_Decidir
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Dc
 * @package    Dc_Decidir
 * @copyright  Copyright (c) 2015 Damián Culotta. (http://www.damianculotta.com.ar/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Dc_Decidir_Model_System_Config_Source_Cards extends Varien_Object
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $cards = Mage::getModel('decidir/decidir_cards')->getCreditCards();
        $options = array();
        foreach ($cards as $value => $label) {
            $options[] = array(
                            'value' => $value,
                            'label' => $label
                        );
        }
        return $options;
    }

}
