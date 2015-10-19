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

class Dc_Decidir_Block_Redirect extends Mage_Core_Block_Abstract
{

    protected function _toHtml()
    {
        $form = new Varien_Data_Form();
        $form->setAction(Mage::helper('decidir')->getPaymentGatewayUrl())
            ->setId('decidir_checkout')
            ->setName('decidir_form')
            ->setMethod('post')
            ->setUseContainer(true);

        $decidir = Mage::getModel('decidir/decidir');
        foreach ($decidir->getCheckoutFormFields() as $field => $value) {
            $form->addField($field, 'hidden', array('name' => $field, 'value' => $value));
            Mage::helper('decidir')->log('Form Field: ' . $field);
            Mage::helper('decidir')->log('Form Value: ' . $value);
        }
				
        $html = $this->__('You will be redirected to Decidir.com');
        $html.= $form->toHtml();
		$html.= '<script type="text/javascript">document.getElementById("decidir_checkout").submit();</script>';

        return $html;
    }

}