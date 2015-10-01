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

class Dc_Decidir_Block_Info_Decidir extends Mage_Payment_Block_Info
{

    protected function _prepareSpecificInformation($transport = null)
    {
        if (null !== $this->_paymentSpecificInformation)
        {
            return $this->_paymentSpecificInformation;
        }

        $data = array();

        if ($this->getInfo()->getCcType()) {
            $data[Mage::helper('decidir')->__('Credit Card')] = $this->getCreditCardName($this->getInfo()->getCcType());
        }

        if ($this->getInfo()->getAdditionalData()) {
            $data[Mage::helper('decidir')->__('Installments')] = $this->getInfo()->getAdditionalData();
        }

        $transport = parent::_prepareSpecificInformation($transport);

        return $transport->setData(array_merge($data, $transport->getData()));
    }

    /**
     * Convert credit card code to label
     *
     * @param $credit_card
     * @return bool
     */
    private function getCreditCardName($credit_card)
    {
        $cards = Mage::getModel('decidir/decidir_cards')->getCreditCards();
        if (!empty($cards[$credit_card])) {
            return $cards[$credit_card];
        }
        return false;
    }

}
