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

use Symfony\Component\HttpFoundation\RequestStack;

class RequestProcessor implements ProcessorInterface
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * RequestProcessor constructor.
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return mixed
     */
    public function process()
    {
        $request = $this->requestStack->getCurrentRequest();
        return $request;
    }
}