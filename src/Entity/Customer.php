<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\Controller\Api\FetchCustomersController;
use App\Entity\Enum\CustomerGender;
use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new GetCollection(
            name: 'api_customers_index',
            controller: FetchCustomersController::class,
            openapi: new Model\Operation(
                summary: 'Retrieves the collection of Customer resources.',
                description: 'Retrieves the collection of Customer resources. Along with the number of requests that were made for this same operation.',
                responses: [
                    Response::HTTP_OK => new Model\Response(
                        content: new \ArrayObject([
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'responseData' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'customers' => ['type' => 'array'],
                                                'requestCount' => ['type' => 'inetegr'],
                                            ],
                                        ],
                                    ],
                                ],
                                'example' => [
                                    'customers' => [
                                        [
                                            'firstname' => 'string',
                                            'lastname' => 'string',
                                            'email' => 'user@example.com',
                                        ],
                                        [
                                            'firstname' => 'string',
                                            'lastname' => 'string',
                                            'email' => 'user@example.com',
                                        ],
                                    ],
                                    'requestCount' => 1,
                                ],
                            ],
                        ])
                    ),
                ]
            )
        ),
        new Post(
            name: 'api_customers_new',
            normalizationContext: ['groups' => ['customer:create']],
            denormalizationContext: ['groups' => ['customer:create']],
        ),
    ],
    paginationEnabled: false,
)]
#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[UniqueEntity(
    fields: ['email'],
    message: "This email '{{ value }}' is already used.",
)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['customer:list', 'customer:create'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['customer:list', 'customer:create'])]
    private ?string $lastname = null;

    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[ORM\Column(length: 150)]
    #[Groups(['customer:list', 'customer:create'])]
    private string $email;

    #[Assert\Choice(
        callback: 'availableGenders',
        message: 'The value {{ value }} is not valid. You must select one of these choices {{ choices }}.',
    )]
    #[ORM\Column(length: 6, nullable: true)]
    #[Groups(['customer:create'])]
    private ?string $gender = null;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return array<string> of available genders
     */
    public static function availableGenders(): array
    {
        return array_map(
            fn (CustomerGender $status) => $status->value,
            CustomerGender::cases()
        );
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
