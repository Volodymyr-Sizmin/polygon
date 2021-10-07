# apiDoc
## Basic
To document api you just need to create a documentation block, it should be place near the corresponding function.

A documentation block starts with /** and end with */.  
This example describes a GET Method to request the User Information by the user's id.  
@api {get} /user/:id Request User information is mandatory, without @api apiDoc ignores a documentation block.  
@apiName must be a unique name and should always be used.  
Format: method + path (e.g. Get + User)  
@apiGroup should always be used, and is used to group related APIs together.  
All other fields are optional, look at their description at [apiDoc-Params](https://apidocjs.com/#params).

Example
```
/**
 * @api {get} /user/:id Request User information
 * @apiName GetUser
 * @apiGroup User
 *
 * @apiParam {Number} id Users unique ID.
 *
 * @apiSuccess {String} firstname Firstname of the User.
 * @apiSuccess {String} lastname  Lastname of the User.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "firstname": "John",
 *       "lastname": "Doe"
 *     }
 *
 * @apiError UserNotFound The id of the User was not found.
 *
 * @apiErrorExample Error-Response:
 *     HTTP/1.1 404 Not Found
 *     {
 *       "error": "UserNotFound"
 *     }
 */
```
### Errors

If you expirience error simular to this 
> The annotation &quot;@apiName&quot; in method App\Controller\LoginController::emailLogin() was never imported.

use @IgnoreAnnotation("apiName")

Example
```
/**
 * @IgnoreAnnotation("apiName")
 * @IgnoreAnnotation("apiGroup")
 * @IgnoreAnnotation("apiParam")
 * @IgnoreAnnotation("apiBody")
 * @IgnoreAnnotation("apiSuccess")
 * @IgnoreAnnotation("apiSuccessExample")
 * @IgnoreAnnotation("apiError")
 * @IgnoreAnnotation("apiErrorExample")
 * @IgnoreAnnotation("apiHeader")
 * @IgnoreAnnotation("apiHeaderExample")
 */
 class LoginController extends AbstractController

```

## Inherit

Using inherit, you can define reusable snippets of your documentation.

Example
```
/**
 * @apiDefine UserNotFoundError
 *
 * @apiError UserNotFound The id of the User was not found.
 *
 * @apiErrorExample Error-Response:
 *     HTTP/1.1 404 Not Found
 *     {
 *       "error": "UserNotFound"
 *     }
 */

/**
 * @api {get} /user/:id Request User information
 * @apiName GetUser
 * @apiGroup User
 *
 * @apiParam {Number} id Users unique ID.
 *
 * @apiSuccess {String} firstname Firstname of the User.
 * @apiSuccess {String} lastname  Lastname of the User.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "firstname": "John",
 *       "lastname": "Doe"
 *     }
 *
 * @apiUse UserNotFoundError
 */

/**
 * @api {put} /user/ Modify User information
 * @apiName PutUser
 * @apiGroup User
 *
 * @apiParam {Number} id          Users unique ID.
 * @apiParam {String} [firstname] Firstname of the User.
 * @apiParam {String} [lastname]  Lastname of the User.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *
 * @apiUse UserNotFoundError
 */
```

## apidoc.json

The apidoc.json in projects dir stores common information about your project like title, short description, version and configuration options like header / footer settings or template specific options for documentation.

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
