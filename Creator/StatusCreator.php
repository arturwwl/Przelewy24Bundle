<?php
/*
 * This file is part of the ArturwwlPrzelewy24Bundle package.
 *
 * (c) Arturwwl <https://arturwwl.pl/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Arturwwl\Przelewy24Bundle\Creator;

use Arturwwl\Przelewy24Bundle\Model\Status;
use Arturwwl\Przelewy24Bundle\Processor\RequestProcessor;

class StatusCreator implements CreatorInterface
{

    /**
     * @var RequestProcessor
     */
    private $requestProcessor;


    /**
     * StatusProcessor constructor.
     * @param RequestProcessor $requestProcessor
     */
    public function __construct(RequestProcessor $requestProcessor)
    {
        $this->requestProcessor = $requestProcessor;
    }

    /**
     * @return Status
     */
    public function create()
    {
        $request = $this->requestProcessor->process();
        $paramContainer = $request->request;
        $status = new Status();
        $status
            ->setMerchantId($paramContainer->get('p24_merchant_id'))
            ->setSessionId($paramContainer->get('p24_session_id'))
            ->setAmount($paramContainer->get('p24_amount'))
            ->setCurrency($paramContainer->get('p24_currency'))
            ->setOrderId($paramContainer->get('p24_order_id'))
            ->setMethod($paramContainer->get('p24_method'))
            ->setStatement($paramContainer->get('p24_statement'))
            ->setSign($paramContainer->get('p24_sign'));

        return $status;
    }

}