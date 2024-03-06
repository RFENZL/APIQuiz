<?php

namespace App\Entity;

use App\Entity\Question;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnswerRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    private ?question $question = null;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    private ?string $sentence = null;
    #[ORM\Column]
    private ?bool $isGood = null;
    #[ORM\ManyToOne(inversedBy: 'relatedAnswers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $relatedQuestion = null;



    public function getId(): ?int
    {
        return $this->id;
    }
    #[Groups(["getAllQuestions"])]
    public function getSentence(): ?string
    {
        return $this->sentence;
    }

    public function setSentence(string $sentence): static
    {
        $this->sentence = $sentence;

        return $this;
    }
    #[Groups(["getAllQuestions"])]
    public function isIsGood(): ?bool
    {
        return $this->isGood;
    }

    public function setIsGood(bool $isGood): static
    {
        $this->isGood = $isGood;

        return $this;
    }

    public function getRelatedQuestion(): ?Question
    {
        return $this->relatedQuestion;
    }

    public function setRelatedQuestion(?Question $relatedQuestion): static
    {
        $this->relatedQuestion = $relatedQuestion;

        return $this;
    }
    public function getQuestion(): ?question
    {
        return $this->question;
    }

    public function setQuestion(?question $question): static
    {
        $this->question = $question;

        return $this;
    }


}
