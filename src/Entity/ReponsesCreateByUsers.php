<?php

namespace App\Entity;

use App\Repository\ReponsesCreateByUsersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponsesCreateByUsersRepository::class)]
class ReponsesCreateByUsers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    #[ORM\Reponse]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?varchar $reponse = null;

    public function getReponse(): ?int
    {
        return $this->reponse;
    }

    public function setReponse(?string $reponse): self
    {
        $this->reponse = $reponse;
        return $this;
    }

    #[ORM\CreateByUser]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?bool $createByUser = null;

    public function getCreateByUser(): ?int
    {
        return $this->createByUser;
    }

    public function setCreateByUser(?bool $createByUser): self
    {
        $this->createByUser = $createByUser;
        return $this;
    }

    #[ORM\status]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?QuestionCreateByUsers $question = null;

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getQuestion(): ?QuestionCreateByUsers
    {
        return $this->question;
    }

    public function setQuestion(?QuestionCreateByUsers $question): static
    {
        $this->question = $question;

        return $this;
    }
    
    
    
}
