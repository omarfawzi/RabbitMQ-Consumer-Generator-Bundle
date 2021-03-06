# RabbitMQ Consumer Generator Bundle

[![Software License][ico-license]](LICENSE.md)
[![Latest Stable Version](https://poser.pugx.org/edfa3ly-backend/rabbitmq-bundle-consumer-generator/v/stable)](https://packagist.org/packages/edfa3ly-backend/rabbitmq-bundle-consumer-generator)
[![Total Downloads](https://poser.pugx.org/edfa3ly-backend/rabbitmq-bundle-consumer-generator/downloads)](https://packagist.org/packages/edfa3ly-backend/rabbitmq-bundle-consumer-generator)
## Install

Via Composer

``` bash
$ composer require edfa3ly-backend/rabbitmq-bundle-consumer-generator
```

## Description 
* An extension bundle for `php-amqplib/rabbitmq-bundle` that generates consumers dynamically over code , converts them to their yaml representation and writes them over your specified path.
## Usage

* Inject the `GeneratorWrapper` in a service of your own creation and use its methods 
```
class ServiceExample
{  

    /** @var GeneratorWrapper $wrapper */
    protected $wrapper;
   
   /**
    * ServiceExample constructor.
    *
    * @param GeneratorWrapper $wrapper
    */
   public function __construct(
       GeneratorWrapper $wrapper
   ) {
       $this->wrapper         = $wrapper;
   }
   
   /**
    * @throws Exception
    */
   public function createConsumers()
   {
       $consumer = new ConsumerSkeleton() ;
       $consumer->setName('the name of your consumer');
       $consumer->setQueueRoutingKeys(['array of routing keys of your consumer']);
       $consumer->setExchangeType('fanout , direct , topic or headers');
       $consumer->setExchangeName('the name of your consumer's exchange');
       $consumer->setQueueName('Queue name');
       $consumer->setCallback('\path\to\your\consumer\callback::class');
       $consumer->setAmqpConsumerType('consumers or batch_consumers');
       
       $this->wrapper->writeConsumers( [$consumer], 'relative\path\to\your\consumers\yaml');
   }
}
``` 

## Console
Now you can generate consumers through command just run `php bin\console consumer:generate` and answer the prompted questions .
## Security

If you discover any security related issues, please email omarfawzi96@gmail.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
