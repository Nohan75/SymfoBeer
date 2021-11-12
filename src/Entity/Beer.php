<?php

namespace App\Entity;

use App\Repository\BeerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BeerRepository::class)
 */
class Beer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Producteur::class, inversedBy="beers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $producteur_id;

    /**
     * @ORM\ManyToOne(targetEntity=Bucket::class, inversedBy="beer_id")
     */
    private $bucket;


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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getProducteurId(): ?Producteur
    {
        return $this->producteur_id;
    }

    public function setProducteurId(?Producteur $producteur_id): self
    {
        $this->producteur_id = $producteur_id;

        return $this;
    }

    public function getBucket(): ?Bucket
    {
        return $this->bucket;
    }

    public function setBucket(?Bucket $bucket): self
    {
        $this->bucket = $bucket;

        return $this;
    }

}
