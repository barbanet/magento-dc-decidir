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

class Dc_Decidir_PaymentController extends Mage_Core_Controller_Front_Action
{

    public function redirectAction()
    {
        $this->loadLayout();
        $block = $this->getLayout()->createBlock('Dc_Decidir_Block_Redirect');
        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
        Mage::getSingleton('checkout/session')->unsQuoteId();
    }

    public function responseAction()
    {
        $this->_redirect('checkout/onepage/success');
        return;
    }

    public function ipnAction()
    {
        $data = $this->getRequest();
        Mage::helper('decidir')->log($data);

        $result = $data->getParam('resultado');
        $order_id = $data->getParam('noperacion');

        Mage::helper('decidir')->log('RESULTADO: ' . $result);
        Mage::helper('decidir')->log('NUMERO OPERACION: ' . $order_id);

        $order = Mage::getModel('sales/order')->loadByIncrementId($order_id);
        if ($result === 'APROBADA' && $order->getId()) {
            $message = Mage::helper('decidir')->__('Payment APPROVED by Decidir.com.');
            $order->addStatusToHistory(Mage::app()->getStore()->getConfig('payment/decidir/order_success_status'), $message, false);
            $order->sendNewOrderEmail();
            $order->save();
        } else {
            if ($order->getId()) {
                $message = Mage::helper('decidir')->__('Payment DISAPPROVED by Decidir.com.');
                $order->addStatusToHistory(Mage::app()->getStore()->getConfig('payment/decidir/order_failure_status'), $message, false);
                $order->sendNewOrderEmail();
                $order->save();
            }
        }
        return;
    }

}
