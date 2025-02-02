<?php
/*
 * This file is part of the ArturwwlPrzelewy24Bundle package.
 *
 * (c) Arturwwl <https://arturwwl.pl/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Arturwwl\Przelewy24Bundle\Controller;

use Arturwwl\Przelewy24Bundle\Factory\VerifyFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;


class StatusController extends Controller
{
    /**
     * @param VerifyFactory $verifyFactory
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function getStatusAction(VerifyFactory $verifyFactory)
    {
        $result = $verifyFactory->create(null, null);

        //result could not be parsed
//        return $this->render('@ArturwwlPrzelewy24/testResult.html.twig', [
//            'result' => $result
//        ]);
        return $this->render('@ArturwwlPrzelewy24/testResult.html.twig', [
            'result' => 'test'
        ]);
    }
}
