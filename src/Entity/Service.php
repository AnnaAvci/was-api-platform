<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ServiceRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['services_read']],
    // allows api to control the type without symfony constraints, using it with Assert\Type
    denormalizationContext: ["disable_type_enforcement" => true],
    collectionOperations: [
        'get' => ['path' => '/photoshoots'],
        'post'
    ],
    itemOperations: [
        'get' => ['path' => '/photoshoots/{id}'],
        'put',
        'delete'
    ],
)]

class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('services_read')]
    private ?string $service_name = null;

    #[ORM\Column(length: 255)]
    #[Groups('services_read')]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    #[Groups('services_read')]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('services_read')]
    private ?string $postcode = null;

    #[ORM\Column(nullable: true)]
    #[Groups('services_read')]
    #[Assert\Type(type: "numeric", message: "The price should be a number")]
    private $price = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: ServicePhoto::class)]
    #[Groups('services_read')]
    private Collection $servicePhotos;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: ServiceComment::class, orphanRemoval: false)]
    #[Groups('services_read')]
    private Collection $serviceComments;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: ServiceBook::class, orphanRemoval: false)]
    private Collection $serviceBooks;

    #[ORM\ManyToOne(inversedBy: 'services')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups('services_read')]
    private ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: PostLike::class, orphanRemoval: false)]
    private Collection $likes;

    public function __construct()
    {
        $this->servicePhotos = new ArrayCollection();
        $this->serviceComments = new ArrayCollection();
        $this->serviceBooks = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceName(): ?string
    {
        return $this->service_name;
    }

    public function setServiceName(string $service_name): self
    {
        $this->service_name = $service_name;

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
     * @return Collection<int, ServicePhoto>
     */
    public function getServicePhotos(): Collection
    {
        return $this->servicePhotos;
    }

    public function addServicePhoto(ServicePhoto $servicePhoto): self
    {
        if (!$this->servicePhotos->contains($servicePhoto)) {
            $this->servicePhotos->add($servicePhoto);
            $servicePhoto->setService($this);
        }

        return $this;
    }

    public function removeServicePhoto(ServicePhoto $servicePhoto): self
    {
        if ($this->servicePhotos->removeElement($servicePhoto)) {
            // set the owning side to null (unless already changed)
            if ($servicePhoto->getService() === $this) {
                $servicePhoto->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ServiceComment>
     */
    public function getServiceComments(): Collection
    {
        return $this->serviceComments;
    }

    public function addServiceComment(ServiceComment $serviceComment): self
    {
        if (!$this->serviceComments->contains($serviceComment)) {
            $this->serviceComments->add($serviceComment);
            $serviceComment->setService($this);
        }

        return $this;
    }

    public function removeServiceComment(ServiceComment $serviceComment): self
    {
        if ($this->serviceComments->removeElement($serviceComment)) {
            // set the owning side to null (unless already changed)
            if ($serviceComment->getService() === $this) {
                $serviceComment->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ServiceBook>
     */
    public function getServiceBooks(): Collection
    {
        return $this->serviceBooks;
    }

    public function addServiceBook(ServiceBook $serviceBook): self
    {
        if (!$this->serviceBooks->contains($serviceBook)) {
            $this->serviceBooks->add($serviceBook);
            $serviceBook->setService($this);
        }

        return $this;
    }

    public function removeServiceBook(ServiceBook $serviceBook): self
    {
        if ($this->serviceBooks->removeElement($serviceBook)) {
            // set the owning side to null (unless already changed)
            if ($serviceBook->getService() === $this) {
                $serviceBook->setService(null);
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
            $like->setService($this);
        }

        return $this;
    }

    public function removeLike(PostLike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getService() === $this) {
                $like->setService(null);
            }
        }

        return $this;
    }
}
