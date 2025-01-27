# Arturwwl Przelewy24 Bundle
This is  **superb easy to use** Przelewy24 Bundle with bulit-in Symfony Events.

## Instalation
```
composer require arturwwl/przelewy24-bundle
```

and then update your `AppKernel.php`:

```php
// ...
class AppKernel extends Kernel
// ...
    public function registerBundles()
    {
        $bundles = [
		// ...
            new Arturwwl\Przelewy24Bundle\ArturwwlPrzelewy24Bundle(),
		// ...
        ];
	}
```

Than add to your `routing.yml` file:

```yaml
#app/config/routing.yml
arturwwl_przelewy24:
    resource: "@ArturwwlPrzelewy24Bundle/Resources/config/routing.xml"
```

If you want to have access to Test Tools add this to `routing_dev.yml`:

```yaml
#app/config/routing_dev.yml
arturwwl_przelewy24:
    resource: "@ArturwwlPrzelewy24Bundle/Resources/config/routing_dev.xml"
```

## Requirements
*Symfony 3.3++* (because bundle is using Symfony Service Autowire)  
*Guzzle ^6.3* (already included in composer.json)

## Config
Add to your config following lines:
```yaml
#app/config/config.yml
arturwwl_przelewy24:
    sandbox: true #or false
    merchant_id: <your-merchant-id>
    crc_key: <your-crc>
```

## Usage
##### 1. Create your super-custom action
In your controller. 
```php
// ...

use Arturwwl\Przelewy24Bundle\Factory\ProcessFactory;
use Arturwwl\Przelewy24Bundle\Model\Payment;

// ...

class AppController extends Controller
{
	
    // ...
	
    public function processAction(ProcessFactory $processFactory)
    {
	    $order = // ... - You are creating your order here  
        $merchantId = $order->getMerchantId();
        $crcKey = $order->getCrcKey();
        		
        $payment = new Payment();
        $payment
            ->setCurrency('PLN')
            ->setSessionId($order->geToken()) //VERY IMPORTANT some unique id from your order in your db
            ->setAmount($order->getAmount())
            ->setDescription($order->getDesc())
            ->setEmail($order->getEmail())
            ->setStatusUrl($this->generateUrl('status'))
            ->setReturnUrl($this->generateUrl('return', [], 0)); // use following syntax to generate absolute url

        $processFactory->setPayment($payment);
        $url = $processFactory->createAndGetUrl($merchantId, $crcKey);


        return $this->redirect($url);
    }
	
    // ...
	
}
```

##### 2. Register Payment Success Event Listener
```yaml
#app/config/services.yml
    AppBundle\EventListener\Przelewy24\PaymentSuccessListener:
        tags:
            - { name: kernel.event_listener, event: przelewy24.event.payment_success }
```

##### 3. Do what only you want with your succeeded payment
```php
namespace AppBundle\EventListener\Przelewy24;

use Arturwwl\Przelewy24Bundle\Event\PaymentEventInterface;

class PaymentSuccessListener
{
    // ..
    
    public function onPrzelewy24EventPaymentSuccess(PaymentEventInterface $event)
    {
        $token = $event->getPayment()->getSessionId();

	// ..

    }
}
```

## Developer Tools
##### Testing connection
To access tests you have to add  `@ArturwwlPrzelewy24Bundle/Resources/config/routing_dev.xml` to your `rounting_dev.yml` file. (check out Instaltion chapter).  
  
After that you have access to `arturwwl_przelewy24_test` route or simpler go to `/p24-test` path and checkout the results.

##### Simulating Payment Success
Due to Przelewy24 native API you are unable to get success response on your localhost, but you can simulate it with Simulating Payment Success Tool.  
  
To access simulating you have to add  `@ArturwwlPrzelewy24Bundle/Resources/config/routing_dev.xml` to your `rounting_dev.yml` file. (check out Instaltion chapter).  
  
After that you can simply go to `/p24-fake-success/{sessionId}` path or redirect to route `arturwwl_przelewy24_fake_success` to make bundle to trigger `przelewy24.event.payment_success` event.