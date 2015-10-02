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

class Dc_Decidir_Block_Form_Decidir extends Mage_Payment_Block_Form
{

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('dc/decidir/form/decidir.phtml');
    }

    /**
     * Get available credit cards.
     *
     * @return mixed
     */
    public function getCreditCards()
    {
        return Mage::getModel('decidir/decidir_cards')->getAvailableCreditCards();
    }

    /**
     * Get max number of installments.
     *
     * @return mixed
     */
    public function getInstallments()
    {
        return Mage::getModel('decidir/decidir_installments')->getAvailableInstallments();
    }

    public function getDescription()
    {
        return Mage::app()->getStore()->getConfig('payment/decidir/description');
    }

}
