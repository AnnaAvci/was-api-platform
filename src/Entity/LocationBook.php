<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LocationBookRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LocationBookRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['locationBooks_read']],
    collectionOperations: [
        'get',
        'post'
    ],
    itemOperations: [
        'get',
        'delete'
    ]
)]
class LocationBook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'locationBooks')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('locationBooks_read')]
    private ?User $location_client = null;

    #[ORM\ManyToOne(inversedBy: 'locationBooks')]
    private ?Location $location = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('locationBooks_read')]
    #[Assert\NotBlank(message: "Please enter the message")]
    private ?string $message = null;

    #[ORM\Column]
    #[Groups('locationBooks_read')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column]
    #[Groups('locationBooks_read')]
    #[Assert\DateTime(message: "Please enter a valid date: YYYY-DD-MM")]
    private $date_start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('locationBooks_read')]
    #[Assert\DateTime(message: "Please enter a valid date: YYYY-DD-MM")]
    private $date_end = null;

    #[ORM\Column]
    #[Groups('locationBooks_read')]
    private ?int $isAccepted = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocationClient(): ?User
    {
        return $this->location_client;
    }

    public function setLocationClient(?User $location_client): self
    {
        $this->location_client = $location_client;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

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

    public function getDateStart()
    {
        return $this->date_start;
    }

    public function setDateStart($date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd()
    {
        return $this->date_end;
    }

    public function setDateEnd($date_end): self
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
