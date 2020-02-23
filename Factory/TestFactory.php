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

use Arturwwl\Przelewy24Bundle\Adapter\TestAdapter;
use Arturwwl\Przelewy24Bundle\Creator\MerchantCreator;

class TestFactory
{
    /**
     * @var MerchantCreator
     */
    private $merchantCreator;

    /**
     * @var TestAdapter
     */
    private $testAdapter;

    /**
     * TestFactory constructor.
     * @param MerchantCreator $merchantCreator
     * @param TestAdapter $testAdapter
     */
    public function __construct(MerchantCreator $merchantCreator, TestAdapter $testAdapter)
    {
        $this->merchantCreator = $merchantCreator;
        $this->testAdapter = $testAdapter;
    }

    /**
     * @return string
     */
    public function create()
    {
        $merchant = $this->merchantCreator->create();
        $this->testAdapter->setMerchant($merchant);
        $result = $this->testAdapter->getContents();
        return $result;
    }
}