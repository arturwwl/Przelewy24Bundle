<?php
/*
 * This file is part of the ArturwwlPrzelewy24Bundle package.
 *
 * (c) Arturwwl <https://arturwwl.pl/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Arturwwl\Przelewy24Bundle\Processor;

use Arturwwl\Przelewy24Bundle\Exception\Exception;
use Arturwwl\Przelewy24Bundle\Creator\MerchantCreator;

class ProcessProcessor implements ProcessorInterface
{

    /**
     * @var string
     */
    private $string;



    /**
     * @var MerchantCreator
     */
    private $merchantCreator;

    /**
     * ProcessProcessor constructor.
     * @param MerchantCreator $merchantCreator
     */
    public function __construct(MerchantCreator $merchantCreator)
    {
        $this->merchantCreator = $merchantCreator;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function process()
    {
        Exception::getExceptionsFromString($this->string, 'process');


        $token = \explode('=', $this->string)[2];

        return $this->merchantCreator->create()->getBaseUri() . 'trnRequest/' . $token;
    }

    /**
     * @param string $string
     */
    public function setString($string)
    {
        $this->string = $string;
    }
}