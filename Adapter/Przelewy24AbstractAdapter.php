<?php
/*
 * This file is part of the ArturwwlPrzelewy24Bundle package.
 *
 * (c) Arturwwl <https://arturwwl.pl/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Arturwwl\Przelewy24Bundle\Adapter;

use Arturwwl\Przelewy24Bundle\Model\Payment;
use Arturwwl\Przelewy24Bundle\Model\Status;
use Arturwwl\Przelewy24Bundle\Model\Merchant;

abstract class Przelewy24AbstractAdapter
{
    /**
     * @var Payment
     */
    protected $payment;

    /**
     * @var Status
     */
    protected $status;

    /**
     * @var Merchant
     */
    protected $merchant;


    protected $apiVer = '3.2';
    protected $testPath = 'testConnection';
    protected $verifyPath = 'trnVerify';
    protected $registerPath = 'trnRegister';

    /**
     * @param Payment $payment
     */
    public function setPayment(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * @param Status $status
     */
    public function setStatus(Status $status)
    {
        $this->status = $status;
    }

    /**
     * @param Merchant $merchant
     */
    public function setMerchant(Merchant $merchant)
    {
        $this->merchant = $merchant;
    }
}