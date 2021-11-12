<?php

namespace App\Entity;

use App\Repository\BucketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BucketRepository::class)
 */
class Bucket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Beer::class, mappedBy="bucket")
     */
    private $beer_id;

    /**
     * @ORM\OneToOne(targetEntity=Client::class, cascade={"persist", "remove"})
     */
    private $client_id;

    public function __construct()
    {
        $this->beer_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Beer[]
     */
    public function getBeerId(): Collection
    {
        return $this->beer_id;
    }

    public function addBeerId(Beer $beerId): self
    {
        if (!$this->beer_id->contains($beerId)) {
            $this->beer_id[] = $beerId;
            $beerId->setBucket($this);
        }

        return $this;
    }

    public function removeBeerId(Beer $beerId): self
    {
        if ($this->beer_id->removeElement($beerId)) {
            // set the owning side to null (unless already changed)
            if ($beerId->getBucket() === $this) {
                $beerId->setBucket(null);
            }
        }

        return $this;
    }

    public function getClientId(): ?Client
    {
        return $this->client_id;
    }

    public function setClientId(?Client $client_id): self
    {
        $this->client_id = $client_id;

        return $this;
    }
}
