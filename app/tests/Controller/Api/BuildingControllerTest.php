<?php
namespace App\Tests\Controller\Api;

use App\Entity\Building;
use App\Tests\AbstractControllerTest;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;

class BuildingControllerTest extends AbstractControllerTest
{
    /**
     * @throws JWTEncodeFailureException
     */
    public function testAll(): void
    {
        $this->entityManager->persist((new Building())
            ->setTitle("Test building")
            ->setAddress("Test address")
            ->setLatitude(48.9166728)
            ->setLongitude(24.7490272)
            ->setFloors(10)
            ->setYear(2020));
        $this->entityManager->flush();

        $this->logInAuthorizedUser('ROLE_ADMIN');
        $this->client->request('GET', 'api/v1/building/');
        $responseContent = $this->client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, [
            "items" => [
                "type" => "array",
                "required" => "items",
                "items" => [
                    "type" => "object",
                    "properties" => [
                        "id" => ['type' => 'string'],
                        "title" => ['type' => 'string'],
                        "address" => ['type' => 'string'],
                        "latitude" => ['type' => 'float'],
                        "longitude" => ['type' => 'float'],
                        "floors" => ['type' => 'integer'],
                        "year" => ['type' => 'integer']
                    ]
                ]
            ]
        ]);
    }
}