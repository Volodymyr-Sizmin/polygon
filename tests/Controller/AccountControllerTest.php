<?php

namespace App\Tests\Controller;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AccountControllerTest extends WebTestCase
{
    protected KernelBrowser $client;
    protected EntityManager $entityManager;
    protected User $user;
    protected string $token;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();

        $user = new User();
        $user->setFirstName('test');
        $user->setLastName('test');
        $user->setUserName('test');
        $user->setEmail('test1@test.com');
        $user->setPassword('$2y$13$GvLkVb116kk1qDi.o4rpiuPzQtflX7pmXXhKXuk5CI9koJkA.9uQO');//hash of test
        $this->entityManager->persist($user);

        $apiToken = new ApiToken($user, true);
        $this->entityManager->persist($apiToken);

        $this->entityManager->flush();

        $this->user = $user;
        $this->token = $apiToken->getToken();
    }

    public function testAccountApi(): void
    {
        $this->client->request('GET', '/api/accounts/logged-in-user', [], [], [
            'HTTP_X-AUTH-TOKEN' => $this->token,
        ]);

        $response = $this->client->getResponse();
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $responseArr = json_decode($response->getContent(), true);

        $this->assertIsInt($responseArr["id"]);
        $this->assertEquals("test", $responseArr["firstName"]);
        $this->assertEquals("test", $responseArr["lastName"]);
        $this->assertEquals("test", $responseArr["userName"]);
    }

    public function testList(): void
    {
        $this->client->request('GET', '/api/accounts', [], [], [
            'HTTP_X-AUTH-TOKEN' => $this->token,
        ]);

        $response = $this->client->getResponse();
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $responseArr = json_decode($response->getContent(), true);
        $this->assertEquals(true, $responseArr["success"]);
        $this->assertCount(3, $responseArr ["users"]);
    }

    public function testUpdate(): void
    {
        $this->client->jsonRequest('PUT', '/api/accounts/' . $this->user->getId(), [
            "firstName" => "1",
            "lastName" => "2",
            "userName" => "3"
        ], [
            'HTTP_X-AUTH-TOKEN' => $this->token,
        ]);

        $response = $this->client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $responseArr = json_decode($response->getContent(), true);
        $this->assertEquals(true, $responseArr["success"]);
        $this->assertEquals("1", $responseArr["user"]["firstName"]);
        $this->assertEquals("2", $responseArr["user"]["lastName"]);
        $this->assertEquals("3", $responseArr["user"]["userName"]);

        $actualUser = $this->entityManager->find(User::class, $this->user->getId());
        $this->assertEquals("1", $actualUser->getFirstName());
        $this->assertEquals("2", $actualUser->getLastName());
        $this->assertEquals("3", $actualUser->getUserName());
    }

    /** Try to set password for another user
     * ! this method in used in testPasswordChange
     * @return void
     */
    private function incorrectUser(): void
    {
        $otherUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'b.astapau@andersenlab.com' ])->getId();

        $this->client->jsonRequest('POST', '/api/accounts/change_pass/' . $otherUser, [
            "oldPassword" => "test",
            "newPassword" => "newtest",
            "confirmPassword" => "newtest"
        ], [
            'HTTP_X-AUTH-TOKEN' => $this->token,
        ]);

        $response = $this->client->getResponse();
        $this->assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode(), 'failed in incorrectUser()');
    }

    /** Try to set invalid password
     * ! this method in used in testPasswordChange
     * @return void
     */
    private function incorrectPassword(): void
    {
        $this->client->jsonRequest('POST', '/api/accounts/change_pass/' . $this->user->getId(), [
            "oldPassword" => "not test",
            "newPassword" => "newtest",
            "confirmPassword" => "newtest"
        ], [
            'HTTP_X-AUTH-TOKEN' => $this->token,
        ]);

        $response = $this->client->getResponse();

        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode(), 'failed in incorrectPassword()');
    }

    /** Try to set new password with invalid password confirmation
     * ! this method in used in testPasswordChange
     * @return void
     */
    private function invalidNewPassword(): void
    {
        $this->client->jsonRequest('POST', '/api/accounts/change_pass/' . $this->user->getId(), [
            "oldPassword" => "test",
            "newPassword" => "n1",
            "confirmPassword" => "newtest"
        ], [
            'HTTP_X-AUTH-TOKEN' => $this->token,
        ]);

        $response = $this->client->getResponse();

        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode(), 'failed in invalidNewPassword()');
    }

    public function testPasswordChange(): void
    {
        $this->incorrectUser();
        $this->incorrectPassword();
        $this->invalidNewPassword();

        $this->client->jsonRequest('POST', '/api/accounts/change_pass/' . $this->user->getId(), [
             "oldPassword" => "test",
             "newPassword" => "newtesttest",
             "confirmPassword" => "newtesttest"
         ], [
             'HTTP_X-AUTH-TOKEN' => $this->token,
         ]);

        $response = $this->client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testDelete(): void
    {
        $this->client->jsonRequest('DELETE', '/api/accounts/' . $this->user->getId(), [], [
            'HTTP_X-AUTH-TOKEN' => $this->token
        ]);

        $response = $this->client->getResponse();

        $this->assertSame(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        $actualUser = $this->entityManager->find(User::class, $this->user->getId());
        $this->assertEquals(true, $actualUser->getIsDeleted());
    }
}
