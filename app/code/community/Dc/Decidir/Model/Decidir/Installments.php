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

class Dc_Decidir_Model_Decidir_Installments extends Varien_Object
{

    /**
     * @return array
     */
    public function getInstallments()
    {
        $maximum_installment = Mage::app()->getStore()->getConfig('payment/decidir/installments');
        $installments = array();
        $i = 1;
        while ($i <= $maximum_installment) {
            $installments[$i] = $i;
            $i++;
        }
        return $installments;
    }

}
