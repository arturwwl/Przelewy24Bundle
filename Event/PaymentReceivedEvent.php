<?php
/*
 * This file is part of the ArturwwlPrzelewy24Bundle package.
 *
 * (c) Arturwwl <https://arturwwl.pl/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Arturwwl\Przelewy24Bundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Arturwwl\Przelewy24Bundle\Model\PaymentInterface;

class PaymentReceivedEvent extends Event implements PaymentEventInterface
{
    private $payment;

    public function getPayment()
    {
        return $this->payment;
    }

    public function setPayment(PaymentInterface $payment)
    {
        $this->payment = $payment;

    }

}
