<?php

namespace App\Entity;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;

use Symfony\Component\Serializer\Annotation\Groups;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\GroupsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupsRepository::class)]
#[ORM\Table(name: '`Groupes`')]
#[ApiResource(
  operations: [
    new GetCollection(
      uriTemplate: '/allGroupes',
      normalizationContext: ['groups'=>['read:Groupes']]
      )
  ]
  )]
  //#[ApiRessource]
class Groupes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    #[Groups(['read:Groupes'])]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /*#[ORM\OneToMany(mappedBy: 'link_group', targetEntity: User::class)]
    private Collection $users;*/

    #[ORM\OneToMany(mappedBy: 'groupes', targetEntity: User::class)]
    private Collection $link_users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->link_users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    /*public function getUsers(): Collection
    {
        return $this->users;
    }*/

    /*public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            //$user->setLinkGroup($this);
        }

        return $this;
    }*/

    /*public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getLinkGroup() === $this) {
                $user->setLinkGroup(null);
            }
        }

        return $this;
    }*/

    /**
     * @return Collection<int, User>
     */
    public function getLinkUsers(): Collection
    {
        return $this->link_users;
    }

    public function addLinkUser(User $linkUser): self
    {
        if (!$this->link_users->contains($linkUser)) {
            $this->link_users->add($linkUser);
            $linkUser->setGroupes($this);
        }

        return $this;
    }

    public function removeLinkUser(User $linkUser): self
    {
        if ($this->link_users->removeElement($linkUser)) {
            // set the owning side to null (unless already changed)
            if ($linkUser->getGroupes() === $this) {
                $linkUser->setGroupes(null);
            }
        }

        return $this;
    }
}
