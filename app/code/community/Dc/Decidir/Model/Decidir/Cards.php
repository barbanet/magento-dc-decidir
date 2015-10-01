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

class Dc_Decidir_Model_Decidir_Cards extends Varien_Object
{

    /**
     * @return array
     */
    public function getCreditCards()
    {
        $cards = array(
                        1 => 'Visa',
                        6 => 'Amex',
                        8 => 'Diners',
                        15 => 'Mastercard',
                        20 => 'Mastercard Test',
                        23 => 'Tarjeta Shopping',
                        24 => 'Tarjeta Naranja',
                        25 => 'Pago Fácil',
                        26 => 'Rapipago',
                        27 => 'Cabal',
                        29 => 'Italcred',
                        30 => 'Argencard',
                        31 => 'Visa Débito',
                        34 => 'Coopeplus',
                        36 => 'Arcash',
                        37 => 'Nexo',
                        38 => 'Credimas',
                        39 => 'Nevada',
                        41 => 'Pagomiscuentas',
                        42 => 'Nativa',
                        43 => 'Tarjeta Mas/Cencosud',
                        44 => 'Cetelem',
                        45 => 'NacionPymes',
                        46 => 'PaySafeCard',
                        47 => 'Monedero Online',
                        48 => 'Caja de Pagos'
                );
        asort($cards);
        return $cards;
    }

    /**
     * @return array
     */
    public function getAvailableCreditCards()
    {
        $cards = array();
        $selected_credit_cards = explode(',', Mage::app()->getStore()->getConfig('payment/decidir/allowed_credit_cards'));
        foreach ($this->getCreditCards() as $card_id => $card_label) {
            if (in_array($card_id, $selected_credit_cards)) {
                $cards[] = array(
                                'code' => $card_id,
                                'name' => $card_label
                            );
            }
        }
        return $cards;
    }

}
