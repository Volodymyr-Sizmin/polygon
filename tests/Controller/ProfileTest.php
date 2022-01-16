<?php

namespace App\Tests;

use App\Entity\VerificationRequest;
use App\Factory\UserFactory;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zenstruck\Foundry\Test\Factories;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;

class ProfileTest extends WebTestCase
{
    use Factories;

    private $client;
    private $user;
    private $faker;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->user = UserFactory::createOne()->object();
        $this->faker = Factory::create();
    }

    public function testUploadProfilePhoto(): void
    {
        $this->client->loginUser($this->user);

        $profilePhoto = new UploadedFile($this->faker->image('/tmp', 100, 100), "image_name" . '.png', 'image/png', null, true);

        $this->client->request('POST', '/api/profile/about/photo', [], ['photo' => $profilePhoto]);

        $response = json_decode($this->client->getResponse()->getContent());

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
        $this->assertTrue($response->success);
        $this->assertSame($response->body->message, 'Profile photo was successfully uploaded.');
    }

    public function testGetProfilePhoto(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('GET', '/api/profile/about/photo');

        $response = json_decode($this->client->getResponse()->getContent());

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertTrue($response->success);
        $this->assertIsString($response->body->url);
    }

     public function testDeleteProfilePhoto(): void
     {
         $this->client->loginUser($this->user);

         $this->client->request('DELETE', '/api/profile/about/photo');

         $response = json_decode($this->client->getResponse()->getContent());

         $this->assertResponseIsSuccessful();
         $this->assertResponseStatusCodeSame(200);
         $this->assertTrue($response->success);
         $this->assertIsString($response->body->message);
     }

     public function testShowUserInfoSuccess(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('GET', '/api/profile/about/info');

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertResponseIsSuccessful();
        $this->assertTrue($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testShowUserInfoFailure(): void
    {
        $this->client->request('GET', '/api/profile/about/info');

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $this->assertSame('Access denied', $responseData->body->message);
    }

    public function testUpdateUserInfoSuccess(): void
    {
        $this->client->loginUser($this->user);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "firstName" => "John",
            "lastName" => "Doe",
            "userName" => "iamJohnDoe",
            "country" => "Belarus",
            "city" => "Minsk",
            "phone" => "+375294444444"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertResponseIsSuccessful();
        $this->assertTrue($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED, $response->getStatusCode());

        $this->assertEquals("John", $responseData->body->firstName);
        $this->assertEquals("Doe", $responseData->body->lastName);
        $this->assertEquals("iamJohnDoe", $responseData->body->userName);
        $this->assertEquals("Belarus", $responseData->body->country);
        $this->assertEquals("Minsk", $responseData->body->city);
        $this->assertEquals("+375294444444", $responseData->body->phone);

        $actualUser = static::getContainer()->get(UserRepository::class)->findOneById($this->user->getId());
        $this->assertEquals("John", $actualUser->getFirstName());
        $this->assertEquals("Doe", $actualUser->getLastName());
        $this->assertEquals("iamJohnDoe", $actualUser->getUserName());
        $this->assertEquals("Belarus", $actualUser->getCity()->getCountry()->getName());
        $this->assertEquals("Minsk", $actualUser->getCity()->getName());
        $this->assertEquals("+375294444444", $actualUser->getPhone());
    }

    public function testUpdateUserInfoFailureAccess(): void
    {
        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "firstName" => "John",
            "lastName" => "Doe",
            "userName" => "iamJohnDoe",
            "country" => "Belarus",
            "city" => "Minsk",
            "phone" => "+375294444444"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $this->assertSame('Access denied', $responseData->body->message);
    }

    public function testUpdateUserInfoFailureInvalidUser(): void
    {
        $this->client->loginUser($this->user);

        $userRepository = static::getContainer()->get(UserRepository::class);
        $invalidUser = $userRepository->findOneByEmail('password@notandersenlab.com');

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $invalidUser->getId(), [
            "firstName" => "John",
            "lastName" => "Doe",
            "userName" => "iamJohnDoe",
            "country" => "Belarus",
            "city" => "Minsk",
            "phone" => "+375294444444"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertSame('You are not allowed to change this user`s data', $responseData->body->message);
    }

    public function testUpdateUserInfoSuccessPhone(): void
    {
        $this->client->loginUser($this->user);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "phone" => "+375291235567"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertResponseIsSuccessful();
        $this->assertTrue($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testUpdateUserInfoFailurePhone(): void
    {
        $this->client->loginUser($this->user);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "phone" => "+375291235566"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('Phone already used', $responseData->body->message);
    }

    public function testUpdateUserInfoFailureValidateName(): void
    {
        $this->client->loginUser($this->user);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "firstName" => "J"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('firstName', $responseData->body->name);
        $this->assertSame('Must be 2 characters or more', $responseData->body->message);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "firstName" => "Joooooooooooooooooooooooooooooooooooooooooooooooooooooooooohn"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('firstName', $responseData->body->name);
        $this->assertSame('Must be 60 characters or less', $responseData->body->message);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "firstName" => ".John"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('firstName', $responseData->body->name);
        $this->assertSame('Can contain letters, numbers, !@#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, and one dot not first or last', $responseData->body->message);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "lastName" => "D"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('lastName', $responseData->body->name);
        $this->assertSame('Must be 2 characters or more', $responseData->body->message);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "lastName" => "Doooooooooooooooooooooooooooooooooooooooooooooooooooooooooooe"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('lastName', $responseData->body->name);
        $this->assertSame('Must be 60 characters or less', $responseData->body->message);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "lastName" => ".Doe"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('lastName', $responseData->body->name);
        $this->assertSame('Can contain letters, numbers, !@#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, and one dot not first or last', $responseData->body->message);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "userName" => "i"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('userName', $responseData->body->name);
        $this->assertSame('Must be 2 characters or more', $responseData->body->message);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "userName" => "iamJoooooooooooooooooooooooooooooooooooooooooooooooooooohnDoe"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('userName', $responseData->body->name);
        $this->assertSame('Must be 60 characters or less', $responseData->body->message);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "userName" => ".iamJohnDoe"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('userName', $responseData->body->name);
        $this->assertSame('Can contain letters, numbers, !@#$%&‘*+—/\=?^_`{|}~!»№;%:?*()[]<>,\' symbols, and one dot not first or last', $responseData->body->message);
    
        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "firstName" => "  "
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('firstName', $responseData->body->name);
        $this->assertSame('Can\'t consist only of spaces', $responseData->body->message);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "lastName" => "  "
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('lastName', $responseData->body->name);
        $this->assertSame('Can\'t consist only of spaces', $responseData->body->message);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "userName" => "  "
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('userName', $responseData->body->name);
        $this->assertSame('Can\'t consist only of spaces', $responseData->body->message);
    }

    public function testUpdateUserInfoFailureValidatePhone(): void
    {
        $this->client->loginUser($this->user);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "phone" => "+375"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('Phone must be 7 characters or more', $responseData->body->message);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "phone" => "+375294444444444"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('Phone must be 15 characters or less', $responseData->body->message);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "phone" => "375294444444"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('Phone can containe first plus symbol and numbers', $responseData->body->message);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "phone" => "+37529444444x"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('Phone can containe first plus symbol and numbers', $responseData->body->message);
    }

    public function testUpdateUserInfoSuccessCity(): void
    {
        $this->client->loginUser($this->user);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "city" => "Minsk"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertResponseIsSuccessful();
        $this->assertTrue($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED, $response->getStatusCode());

        $actualUser = static::getContainer()->get(UserRepository::class)->findOneById($this->user->getId());
        $this->assertEquals("Belarus", $actualUser->getCity()->getCountry()->getName());
        $this->assertEquals("Minsk", $actualUser->getCity()->getName());
    }

    public function testUpdateUserInfoFailureCity(): void
    {
        $this->client->loginUser($this->user);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "city" => "SomeCity"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('You have to choose right city', $responseData->body->message);
        $cityNames = [
            "Gomel",
            "Minsk",
            "Polotsk",
            "Vitebsk",
            "Krakow",
            "Kazan",
            "Remote RF",
            "Rostov",
            "Saint-Petersburg",
            "Cherkasy",
            "Chernihiv",
            "Dnipro",
            "Kharkiv",
            "Kyiv",
            "Odessa"
        ];
        $this->assertSame($cityNames, $responseData->body->cities);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "country" => "Belarus"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('You have to choose right city', $responseData->body->message);
        $cityNames = [
            "Gomel",
            "Minsk",
            "Polotsk",
            "Vitebsk"
        ];
        $this->assertSame($cityNames, $responseData->body->cities);
    }

    public function testUpdateUserInfoFailureCountry(): void
    {
        $this->client->loginUser($this->user);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "country" => "SomeCountry"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('You have to choose right country', $responseData->body->message);
        $countryNames = [
            "Belarus",
            "Poland",
            "Russia",
            "Ukraine"
        ];
        $this->assertSame($countryNames, $responseData->body->countries);
    }

    public function testUpdateUserInfoFailureCityDoNotRelatedToCountry(): void
    {
        $this->client->loginUser($this->user);

        $this->client->jsonRequest('PUT', '/api/profile/about/info/' . $this->user->getId(), [
            "country" => "Russia",
            "city" => "Minsk"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('You have to choose right country for the Minsk', $responseData->body->message);
        $this->assertSame('Belarus', $responseData->body->country);
    }

    public function testCheckPasswordSuccess(): void
    {
        $user = static::getContainer()->get(UserRepository::class)->findOneBy(['email' => 'b.astapau@andersenlab.com']);
        $this->client->loginUser($user);

        $this->client->request('POST', '/api/profile/about/password/' . $user->getId(), [
            "password" => "password"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testCheckPasswordFailure(): void
    {
        $user = static::getContainer()->get(UserRepository::class)->findOneBy(['email' => 'b.astapau@andersenlab.com']);
        $this->client->loginUser($user);

        $this->client->request('POST', '/api/profile/about/password/' . $user->getId(), [
            "password" => "wrongpassword"
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('Wrong password. Please try again', $responseData->body->message);
    }

    public function testCheckPasswordFailureEmpty(): void
    {
        $user = static::getContainer()->get(UserRepository::class)->findOneBy(['email' => 'b.astapau@andersenlab.com']);
        $this->client->loginUser($user);

        $this->client->request('POST', '/api/profile/about/password/' . $user->getId(), [
            "password" => ""
        ]);

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent());

        $this->assertFalse($responseData->success);
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('Empty input', $responseData->body->message);
    }

    private function checkEmail($url): void 
    {
        $this->assertEmailCount(1);
        $email = $this->getMailerMessage();
        $this->assertEmailHtmlBodyContains($email, $url, 'email html doesn\'t have a url');
        $this->assertEmailTextBodyContains($email, $url, 'email text doesn\'t have a url');
    }

    public function testVerificationRequest(): void
    {
        $this->client->loginUser($this->user);
        $this->client->Request('POST', '/api/profile/about/email/' . $this->user->getId(), [
            "email"=>"verification@notandersenlab.com", 
        ]);
        $response = $this->client->getResponse();
        $this->assertSame(201, $response->getStatusCode());
        $responseData = json_decode($response->getContent());
        $this->assertSame($responseData->success, true);
        $url = '/api/profile/about/email/'.$responseData->body->url;
        $this->checkEmail($url);
        $this->client->Request('GET', $url);
        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $request = $entityManager->getRepository(VerificationRequest::class)->findOneBy(['email' => 'verification@notandersenlab.com']);
        $this->assertTrue($request->getVerified());
        $this->assertSame($this->user->getId(), $request->getUser()->getId());
    }
}
