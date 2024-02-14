<?php
namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Helmich\JsonAssert\JsonAssertions;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractControllerTest extends WebTestCase
{
    use JsonAssertions;

    protected KernelBrowser $client;

    protected ?EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->entityManager = self::getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * @throws JWTEncodeFailureException
     */
    protected function logInUnauthorizedUser(): void
    {
        /** @var JWTEncoderInterface $jwtEncoder */
        $jwtEncoder = $this->client->getContainer()->get('lexik_jwt_authentication.encoder');

        $token = $jwtEncoder->encode([
            'username' => 'test_auth',
            'permissions' => [],
            'user_id' => 1,
            'first_name' => 'Test',
            'last_name' => 'Unauthorized',
            'email' => 'test.unauthorized@acme.com',
            'locale' => 'ua'
        ]);

        $this->client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $token));
    }

    /**
     * @throws JWTEncodeFailureException
     */
    protected function logInAuthorizedUser(string $role): void
    {
        /** @var JWTEncoderInterface $jwtEncoder */
        $jwtEncoder = $this->client->getContainer()->get('lexik_jwt_authentication.encoder');

        $token = $jwtEncoder->encode([
            'username' => 'john_admin',
            'permissions' => [$role],
            'user_id' => 1,
            'first_name' => 'Test',
            'last_name' => 'Authorized',
            'email' => 'test.authorized@acme.com',
            'locale' => 'ua'
        ]);

        $this->client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $token));
    }
}