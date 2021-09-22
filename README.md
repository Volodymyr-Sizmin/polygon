# Testing
To access testing functionality you should enter symthony-api(app/enter symfony-api)
## Running tests
To run all tests use 
```
php bin/phpunit
```
You can also run all test from specific directory
```
php bin/phpunit tests/Form
```
or class 
```
php bin/phpunit tests/Form/UserTypeTest.php
```
## Creating tests
To create test run
```
php bin/console make:test
```
You will be presented with chose of type. Use WebTestCase for api tests.
Then you have to choose class name. It's a good practice to mimic src dir path. For example use Controller\PostControllerTest to test logic in PostController

Test should be created in tests dir.

Test logic is written in functins with names test#####() 

Example test
```
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PingTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/ping');
        $response = $client->getResponse();
        $this->assertSame(200,$response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame($responseData->success, 'pong');
    }
}
```

For more in depth info read [symfony docs](https://symfony.com/doc/current/testing.html) and [phpunit docs](https://phpunit.de/documentation.html).


