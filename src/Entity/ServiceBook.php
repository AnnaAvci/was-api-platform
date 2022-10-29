<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ServiceBookRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServiceBookRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['serviceBooks_read']],
    collectionOperations: [
        'get',
        'post'
    ],
    itemOperations: [
        'get',
        'delete'
    ],
    paginationEnabled: false
)]
class ServiceBook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'serviceBooks')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('serviceBooks_read')]
    private ?User $service_client = null;

    #[ORM\ManyToOne(inversedBy: 'serviceBooks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('serviceBooks_read')]
    #[Assert\NotBlank(message: "Please enter the message")]
    private ?string $message = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('serviceBooks_read')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('serviceBooks_read')]
    #[Assert\DateTime(message: "Please enter a valid date: YYYY-DD-MM")]
    private ?\DateTimeInterface $date_start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('serviceBooks_read')]
    #[Assert\DateTime(message: "Please enter a valid date: YYYY-DD-MM")]
    private ?\DateTimeInterface $date_end = null;

    #[ORM\Column]
    #[Groups('serviceBooks_read')]
    private ?int $isAccepted = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceClient(): ?User
    {
        return $this->service_client;
    }

    public function setServiceClient(?User $service_client): self
    {
        $this->service_client = $service_client;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getIsAccepted(): ?int
    {
        return $this->isAccepted;
    }

    public function setIsAccepted(int $isAccepted): self
    {
        $this->isAccepted = $isAccepted;

        return $this;
    }
}
