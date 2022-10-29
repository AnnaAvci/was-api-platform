<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource (
    normalizationContext: ['groups' => ['users_read']]
)]
#[UniqueEntity(
    fields: ['email'],
    message: 'This email is already registered',
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups('users_read')]
    #[Assert\NotBlank(message: "Please enter your email address")]
    #[Assert\Email(message: "Please enter a valid email address")]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(message: "Please enter your email password")]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Groups('users_read', 'locations_read', 'services_read', 'serviceBooks_read', 'locationBooks_read', 'serviceComments_read', 'locationComments_read')]
    #[Assert\NotBlank(message: "Please enter your first name")]
    #[Assert\Length(min: 2, minMessage: "2 characters minimum", max: 255, maxMessage: "255 characters maximum")]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    #[Groups('users_read', 'locations_read', 'services_read', 'serviceBooks_read', 'locationBooks_read', 'serviceComments_read', 'locationComments_read')]
    #[Assert\NotBlank(message: "Please enter your last name")]
    #[Assert\Length(min: 2, minMessage: "2 characters minimum", max: 255, maxMessage: "255 characters maximum")]
    private ?string $last_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('users_read')]
    private ?string $profile_picture = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $registeredAt = null;

    #[ORM\Column(length: 255)]
    #[Groups('users_read')]
    #[Assert\NotBlank(message: "Please enter your country")]
    private ?string $country_user = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter your city")]
    private ?string $city_user = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter your postcode")]
    private ?string $postcode_user = null;

    #[ORM\Column]
    private ?bool $isVerified = null;

    #[ORM\OneToMany(mappedBy: 'sender', targetEntity: Message::class)]
    #[ApiSubresource()]
    private Collection $messages;

    #[ORM\OneToMany(mappedBy: 'recipient', targetEntity: Message::class)]
    #[ApiSubresource()]
    private Collection $messages_received;

    #[ORM\OneToMany(mappedBy: 'commenter', targetEntity: LocationComment::class)]
    #[ApiSubresource()]
    private Collection $locationComments;

    #[ORM\OneToMany(mappedBy: 'commenter', targetEntity: ServiceComment::class)]
    #[ApiSubresource()]
    private Collection $serviceComments;

    #[ORM\OneToMany(mappedBy: 'service_client', targetEntity: ServiceBook::class, orphanRemoval: true)]
    #[ApiSubresource()]
    private Collection $serviceBooks;

    #[ORM\OneToMany(mappedBy: 'location_client', targetEntity: LocationBook::class)]
    #[ApiSubresource()]
    private Collection $locationBooks;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Location::class, orphanRemoval: false)]
    #[ApiSubresource()]
    private Collection $locations;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Service::class, orphanRemoval: false)]
    #[ApiSubresource()]
    private Collection $services;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: PostLike::class, orphanRemoval: false)]
    #[ApiSubresource()]
    private Collection $likes;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->messages_received = new ArrayCollection();
        $this->locationComments = new ArrayCollection();
        $this->serviceComments = new ArrayCollection();
        $this->serviceBooks = new ArrayCollection();
        $this->locationBooks = new ArrayCollection();
        $this->locations = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profile_picture;
    }

    public function setProfilePicture(?string $profile_picture): self
    {
        $this->profile_picture = $profile_picture;

        return $this;
    }


    public function getRegisteredAt(): ?\DateTimeInterface
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(\DateTimeInterface $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getCountryUser(): ?string
    {
        return $this->country_user;
    }

    public function setCountryUser(string $country_user): self
    {
        $this->country_user = $country_user;

        return $this;
    }

    public function getCityUser(): ?string
    {
        return $this->city_user;
    }

    public function setCityUser(string $city_user): self
    {
        $this->city_user = $city_user;

        return $this;
    }

    public function getPostcodeUser(): ?string
    {
        return $this->postcode_user;
    }

    public function setPostcodeUser(string $postcode_user): self
    {
        $this->postcode_user = $postcode_user;

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setSender($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getSender() === $this) {
                $message->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessagesReceived(): Collection
    {
        return $this->messages_received;
    }

    public function addMessagesReceived(Message $messagesReceived): self
    {
        if (!$this->messages_received->contains($messagesReceived)) {
            $this->messages_received->add($messagesReceived);
            $messagesReceived->setRecipient($this);
        }

        return $this;
    }

    public function removeMessagesReceived(Message $messagesReceived): self
    {
        if ($this->messages_received->removeElement($messagesReceived)) {
            // set the owning side to null (unless already changed)
            if ($messagesReceived->getRecipient() === $this) {
                $messagesReceived->setRecipient(null);
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
            $locationComment->setCommenter($this);
        }

        return $this;
    }

    public function removeLocationComment(LocationComment $locationComment): self
    {
        if ($this->locationComments->removeElement($locationComment)) {
            // set the owning side to null (unless already changed)
            if ($locationComment->getCommenter() === $this) {
                $locationComment->setCommenter(null);
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
            $serviceComment->setCommenter($this);
        }

        return $this;
    }

    public function removeServiceComment(ServiceComment $serviceComment): self
    {
        if ($this->serviceComments->removeElement($serviceComment)) {
            // set the owning side to null (unless already changed)
            if ($serviceComment->getCommenter() === $this) {
                $serviceComment->setCommenter(null);
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
            $serviceBook->setServiceClient($this);
        }

        return $this;
    }

    public function removeServiceBook(ServiceBook $serviceBook): self
    {
        if ($this->serviceBooks->removeElement($serviceBook)) {
            // set the owning side to null (unless already changed)
            if ($serviceBook->getServiceClient() === $this) {
                $serviceBook->setServiceClient(null);
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
            $locationBook->setLocationClient($this);
        }

        return $this;
    }

    public function removeLocationBook(LocationBook $locationBook): self
    {
        if ($this->locationBooks->removeElement($locationBook)) {
            // set the owning side to null (unless already changed)
            if ($locationBook->getLocationClient() === $this) {
                $locationBook->setLocationClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations->add($location);
            $location->setOwner($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getOwner() === $this) {
                $location->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setOwner($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getOwner() === $this) {
                $service->setOwner(null);
            }
        }

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
            $like->setUser($this);
        }

        return $this;
    }

    public function removeLike(PostLike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getUser() === $this) {
                $like->setUser(null);
            }
        }

        return $this;
    }
}
