<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LocationRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: LocationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['locations_read']],
    // allows api to control the type without symfony constraints
    denormalizationContext: ["disable_type_enforcement" => true],
    collectionOperations: [
        'get',
        'post'
    ],
    itemOperations: [
        'get',
        'put',
        'delete'
    ],
)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('locations_read')]
    #[Assert\NotBlank(message: "Please enter the name of the location")]
    private ?string $location_name = null;

    #[ORM\Column(length: 255)]
    #[Groups('customers_read')]
    #[Assert\NotBlank(message: "Please enter the country")]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    #[Groups('customers_read')]
    #[Assert\NotBlank(message: "Please enter the city")]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('customers_read')]
    private ?string $postcode = null;

    #[ORM\Column(nullable: true)]
    #[Groups('customers_read')]
    #[Assert\Type(type: "numeric", message: "The price should be a number")]
    private $price = null;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: LocationPhoto::class)]
    #[Groups('customers_read')]
    private Collection $locationPhotos;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: LocationComment::class)]
    #[Groups('customers_read')]
    private Collection $locationComments;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: LocationBook::class, orphanRemoval: false)]
    private Collection $locationBooks;

    #[ORM\ManyToOne(inversedBy: 'locations')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups('locations_read')]
    private ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: PostLike::class, orphanRemoval: false)]
    private Collection $likes;

    public function __construct()
    {
        $this->locationPhotos = new ArrayCollection();
        $this->locationComments = new ArrayCollection();
        $this->locationBooks = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocationName(): ?string
    {
        return $this->location_name;
    }

    public function setLocationName(string $location_name): self
    {
        $this->location_name = $location_name;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, LocationPhoto>
     */
    public function getLocationPhotos(): Collection
    {
        return $this->locationPhotos;
    }

    public function addLocationPhoto(LocationPhoto $locationPhoto): self
    {
        if (!$this->locationPhotos->contains($locationPhoto)) {
            $this->locationPhotos->add($locationPhoto);
            $locationPhoto->setLocation($this);
        }

        return $this;
    }

    public function removeLocationPhoto(LocationPhoto $locationPhoto): self
    {
        if ($this->locationPhotos->removeElement($locationPhoto)) {
            // set the owning side to null (unless already changed)
            if ($locationPhoto->getLocation() === $this) {
                $locationPhoto->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LocationComment>
     */
    public function getLocationComments(): Collection
    {
        return $this->locationComments;
    }

    public function addLocationComment(LocationComment $locationComment): self
    {
        if (!$this->locationComments->contains($locationComment)) {
            $this->locationComments->add($locationComment);
            $locationComment->setLocation($this);
        }

        return $this;
    }

    public function removeLocationComment(LocationComment $locationComment): self
    {
        if ($this->locationComments->removeElement($locationComment)) {
            // set the owning side to null (unless already changed)
            if ($locationComment->getLocation() === $this) {
                $locationComment->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LocationBook>
     */
    public function getLocationBooks(): Collection
    {
        return $this->locationBooks;
    }

    public function addLocationBook(LocationBook $locationBook): self
    {
        if (!$this->locationBooks->contains($locationBook)) {
            $this->locationBooks->add($locationBook);
            $locationBook->setLocation($this);
        }

        return $this;
    }

    public function removeLocationBook(LocationBook $locationBook): self
    {
        if ($this->locationBooks->removeElement($locationBook)) {
            // set the owning side to null (unless already changed)
            if ($locationBook->getLocation() === $this) {
                $locationBook->setLocation(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, PostLike>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(PostLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->setLocation($this);
        }

        return $this;
    }

    public function removeLike(PostLike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getLocation() === $this) {
                $like->setLocation(null);
            }
        }

        return $this;
    }
}
