<?php
/*
 * This file is part of the ArturwwlPrzelewy24Bundle package.
 *
 * (c) Arturwwl <https://arturwwl.pl/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Arturwwl\Przelewy24Bundle\Factory;

use Arturwwl\Przelewy24Bundle\Adapter\RegisterAdapter;
use Arturwwl\Przelewy24Bundle\Creator\MerchantCreator;
use Arturwwl\Przelewy24Bundle\Model\Payment;
use Arturwwl\Przelewy24Bundle\Processor\ProcessProcessor;

class ProcessFactory
{
    /**
     * @var Payment
     */
    private $payment;

    /**
     * @var MerchantCreator
     */
    private $merchantCreator;

    /**
     * @var ProcessProcessor
     */
    private $processProcessor;

    /**
     * @var RegisterAdapter
     */
    private $registerAdapter;

    /**
     * ProcessFactory constructor.
     *
     * @param MerchantCreator $merchantCreator
     * @param RegisterAdapter $registerAdapter
     * @param ProcessProcessor $processProcessor
     */
    public function __construct(MerchantCreator $merchantCreator, RegisterAdapter $registerAdapter, ProcessProcessor $processProcessor)
    {
        $this->merchantCreator = $merchantCreator;
        $this->registerAdapter = $registerAdapter;
        $this->processProcessor = $processProcessor;
    }

    /**
     * @param $merchantId
     * @param $crc
     * @return string
     * @throws \Exception
     */
    public function createAndGetUrl($merchantId = null, $crc = null): string
    {
        $merchant = $this->merchantCreator->create();

        if ($merchantId)
        {
            $merchant->setMerchantId($merchantId);
            $merchant->setPosId($merchantId);
        }

        if($crc)
        {
            $merchant->setCrc($crc);
        }

        $this->registerAdapter->setMerchant($merchant);
        $this->registerAdapter->setPayment($this->payment);

        $result = $this->registerAdapter->getContents();

        $this->processProcessor->setString($result);
        $url = $this->processProcessor->process();

        $urlExploded = explode('/', $url);
        $this->payment->setOrderId(end($urlExploded));
        return $url;
    }

    /**
     * @param Payment $payment
     */
    public function setPayment(Payment $payment)
    {
        $this->payment = $payment;
    }

}