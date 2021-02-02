<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @Vich\Uploadable()
 */
class Book
{
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $editeur;

    /**
     * @ORM\Column(type="date")
     */
    private $anneeParution;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $collection;

    /**
     * @ORM\Column(type="integer")
     */
    private $countPage;

   
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @Assert\NotBlank(message="SVP, Entrez un fichier pdf.")
     * @Assert\File(mimeTypes={"application/pdf"})
     */
    private $document;

    
    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
       
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getEditeur(): ?string
    {
        return $this->editeur;
    }

    public function setEditeur(string $editeur): self
    {
        $this->editeur = $editeur;

        return $this;
    }

    public function getAnneeParution(): ?\DateTimeInterface
    {
        return $this->anneeParution;
    }

    public function setAnneeParution(\DateTimeInterface $anneeParution): self
    {
        $this->anneeParution = $anneeParution;

        return $this;
    }

    public function getCollection(): ?string
    {
        return $this->collection;
    }

    public function setCollection(string $collection): self
    {
        $this->collection = $collection;

        return $this;
    }

    public function getCountPage(): ?int
    {
        return $this->countPage;
    }

    public function setCountPage(int $countPage): self
    {
        $this->countPage = $countPage;

        return $this;
    }

    

    /**
     * @return null|string
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    } 

    /**
     * @param null|string $filename
     * @return Book
     */
    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;
        
        return $this;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(?string $document): self
    {
        $this->document = $document;

        return $this;
    }

    

   
}
