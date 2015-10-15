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

class Dc_Decidir_Model_Decidir extends Mage_Payment_Model_Method_Abstract
{

    protected $_code  = 'decidir';

    protected $_formBlockType = 'decidir/form_decidir';

    protected $_infoBlockType = 'decidir/info_decidir';

    public function assignData($data)
    {
        $info = $this->getInfoInstance();

        if ($data->getCcType()) {
            $info->setCcType($data->getCcType());
        }

        if ($data->getAdditionalData()) {
            $info->setAdditionalData($data->getAdditionalData());
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getCheckoutFormFields()
    {
        $order = Mage::getModel('sales/order');
        $order->loadByIncrementId(Mage::getSingleton('checkout/session')->getLastRealOrderId());

        $id_transaction = '|NROCOMERCIO:' . $this->getMerchantId();
        $id_transaction .= '|MONTO:' . ($order->getBaseTotalDue() * 100);
        $id_transaction .= '|MEDIODEPAGO:' . $order->getPayment()->getCcType();
        $id_transaction .= '|NROOPERACION:' . $order->getIncrementId();
        $id_transaction .= '|CUOTAS:' . str_pad($order->getPayment()->getAdditionalData(), 2, "0", STR_PAD_LEFT);
        $id_transaction .= '|CLAVE:' . $this->getMerchantPassword();
        $id_transaction .= '|';

        Mage::helper('decidir')->log($id_transaction);
        Mage::helper('decidir')->log(sha1($id_transaction));

        $data = array(
            'NROCOMERCIO'   => $this->getMerchantId(),
            'NROOPERACION'  => $order->getIncrementId(),
            'MONTO'         => ($order->getBaseTotalDue() * 100),
            'CUOTAS'        => str_pad($order->getPayment()->getAdditionalData(), 2, "0", STR_PAD_LEFT),
            'MEDIODEPAGO'   => $order->getPayment()->getCcType(),
            'URLDINAMICA'   => Mage::getBaseUrl() . 'decidir/payment/response',
            'EMAILCLIENTE'  => $order->getCustomerEmail(),
            'IDTRANSACCION' => sha1($id_transaction)
        );

        Mage::helper('decidir')->log($data);

        return $data;
    }

    /**
     * @return null|string
     */
    private function isTestMode()
    {
        return Mage::app()->getStore()->getConfig('payment/decidir/test_mode');
    }

    /**
     * @return null|string
     */
    private function getMerchantId()
    {
        if ($this->isTestMode()) {
            return Mage::app()->getStore()->getConfig('payment/decidir/merchant_id_test');
        } else {
            return Mage::app()->getStore()->getConfig('payment/decidir/merchant_id');
        }
    }

    /**
     * @return null|string
     */
    private function getMerchantPassword()
    {
        if ($this->isTestMode()) {
            return Mage::app()->getStore()->getConfig('payment/decidir/merchant_password_test');
        } else {
            return Mage::app()->getStore()->getConfig('payment/decidir/merchant_password');
        }
    }

    /**
     * @return string
     */
    public function getOrderPlaceRedirectUrl()
    {
        return Mage::getUrl('decidir/payment/redirect', array('_secure' => false));
    }

}
