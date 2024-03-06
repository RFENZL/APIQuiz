<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[Groups(["getAllQuestions"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;
    #[Groups(["getAllQuestions"])]
    #[ORM\Column(length: 255)]
    private ?string $question = null;
    #[Groups(["getAllQuestions"])]
    #[ORM\Column(length: 255)]
    private ?string $category = null;
    #[Groups(["getAllQuestions"])]
    #[ORM\Column(length: 255)]
    private ?string $difficulty = null;
    #[Groups(["getAllQuestions"])]
    #[ORM\Column(type: Types::GUID)]
    private ?string $jomoreschiId = null;
    #[Groups(["getAllQuestions"])]
    #[ORM\OneToMany(mappedBy: 'relatedQuestion', targetEntity: Answer::class, orphanRemoval: true)]
    private Collection $relatedAnswers;

    #[ORM\Column]
    private ?bool $isCreatedByUsers = null;

    #[ORM\Column(length: 255)]
    private ?string $Status = null;


    public function __construct()
    {
        $this->relatedAnswers = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(string $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getJomoreschiId(): ?string
    {
        return $this->jomoreschiId;
    }

    public function setJomoreschiId(string $jomoreschiId): static
    {
        $this->jomoreschiId = $jomoreschiId;

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    
    public function getRelatedAnswers(): Collection
    {
        return $this->relatedAnswers;
    }

    public function addRelatedAnswer(Answer $relatedAnswer): static
    {
        if (!$this->relatedAnswers->contains($relatedAnswer)) {
            $this->relatedAnswers->add($relatedAnswer);
            $relatedAnswer->setRelatedQuestion($this);
        }

        return $this;
    }

    public function removeRelatedAnswer(Answer $relatedAnswer): static
    {
        if ($this->relatedAnswers->removeElement($relatedAnswer)) {
            // set the owning side to null (unless already changed)
            if ($relatedAnswer->getRelatedQuestion() === $this) {
                $relatedAnswer->setRelatedQuestion(null);
            }
        }

        return $this;
    }

    public function isIsCreatedByUsers(): ?bool
    {
        return $this->isCreatedByUsers;
    }

    public function setIsCreatedByUsers(bool $isCreatedByUsers): static
    {
        $this->isCreatedByUsers = $isCreatedByUsers;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): static
    {
        $this->Status = $Status;

        return $this;
    }



}





