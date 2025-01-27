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

use Arturwwl\Przelewy24Bundle\Adapter\VerifyAdapter;
use Arturwwl\Przelewy24Bundle\Creator\StatusCreator;
use Arturwwl\Przelewy24Bundle\Creator\MerchantCreator;
use Arturwwl\Przelewy24Bundle\Processor\VerifyProcessor;

class VerifyFactory
{
    /**
     * @var VerifyAdapter
     */
    private $verifyAdapter;

    /**
     * @var StatusCreator
     */
    private $statusCreator;

    /**
     * @var MerchantCreator
     */
    private $merchantCreator;

    /**
     * @var VerifyProcessor
     */
    private $verifyProcessor;

    /**
     * VerifyFactory constructor.
     * @param VerifyAdapter $verifyAdapter
     * @param StatusCreator $statusCreator
     * @param MerchantCreator $merchantCreator
     */
    public function __construct(VerifyAdapter $verifyAdapter, StatusCreator $statusCreator, MerchantCreator $merchantCreator, VerifyProcessor $verifyProcessor)
    {
        $this->verifyAdapter = $verifyAdapter;
        $this->statusCreator = $statusCreator;
        $this->merchantCreator = $merchantCreator;
        $this->verifyProcessor = $verifyProcessor;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function create($merchantId, $crc)
    {
        $status = $this->statusCreator->create();

        $this->verifyAdapter->setStatus($status);

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

        $this->verifyAdapter->setMerchant($merchant);

        $result = $this->verifyAdapter->getContents();

        $this->verifyProcessor->setSessionId($status->getSessionId());
        $this->verifyProcessor->setString($result);

        return $this->verifyProcessor->process();
    }
}