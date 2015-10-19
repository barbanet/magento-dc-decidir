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

class Dc_Decidir_Helper_Data extends Mage_Core_Helper_Data
{

    /**
     * @return string
     */
    public function getPaymentGatewayUrl()
    {
        return 'https://sps.decidir.com/sps-ar/Validar';
    }

    /**
     * @param $message
     */
    public function log($message)
    {
        if (Mage::app()->getStore()->getConfig('payment/decidir/debug_log')) {
            Mage::log($message, null, 'decidir-' . date('Y-m-d') . '.log', true);
        }
    }

}
