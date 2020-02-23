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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Arturwwl\Przelewy24Bundle\Factory\TestFactory;
use Arturwwl\Przelewy24Bundle\Processor\VerifyProcessor;

class TestController extends Controller
{
    /**
     * @param TestFactory $testFactory
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function testAction(TestFactory $testFactory)
    {
        $result = $testFactory->create();

        return $this->render('@ArturwwlPrzelewy24/testResult.html.twig', [
            'result' => $result
        ]);
    }

    /**
     * @param VerifyProcessor $verifyProcessor
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function fakeSuccessAction(VerifyProcessor $verifyProcessor, $sessionId)
    {
        $verifyProcessor->setSessionId($sessionId);
        $verifyProcessor->setString('error=0');
        $verifyProcessor->process();

        $result = 'ArturwwlPrzelewy24Bundle:Test:fakeSuccess';

        return $this->render('@ArturwwlPrzelewy24/testResult.html.twig', [
            'result' => $result
        ]);
    }
}
