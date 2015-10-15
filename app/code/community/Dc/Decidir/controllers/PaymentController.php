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
    }

    public function responseAction()
    {
        if ($this->getRequest()->get('resultado') === 'APROBADA') {
            $order_id = Mage::getSingleton('checkout/session')->getLastOrderId();
            $order = Mage::getModel('sales/order')->load($order_id);
            if ($order->getId()) {
                $message = Mage::helper('decidir')->__('Payment approved by Decidir.com.');
                $order->addStatusToHistory(Mage::app()->getStore()->getConfig('payment/decidir/order_status'), $message, false);
                $order->sendNewOrderEmail();
                $order->save();
            }
            Mage::getSingleton('checkout/session')->unsQuoteId();
            $this->_redirect('checkout/onepage/success');
            return;
        } else {
            $this->_redirect('checkout/onepage/failure');
            return;
        }
    }

}
