<?php

namespace App\Entity;

use GuzzleHttp\Client;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\QuestionCreateByUsersRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuestionCreateByUsersRepository::class)]
class QuestionCreateByUsers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Groups(["getAllQuestions"])]
    #[ORM\Column(length: 255)]
    private ?string $question = null;

    #[ORM\Column(length: 255)]
    private ?string $CreatedByUser = null;

    #[ORM\Column]
    private ?bool $Status = null;
    #[Groups(["getAllQuestions"])]
    public function getId(): ?int
    {
        return $this->id;
    }
    #[Groups(["getAllQuestions"])]
    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }
    #[Groups(["getAllQuestions"])]
    public function getCreatedByUser(): ?string
    {
        $apiUrl = 'https://quizzapi.jomoreschi.fr/api/v1/quiz';

        $client = new Client();
        $response = $client->get($apiUrl);

        $statusCode = $response->getStatusCode();

        if ($statusCode === 200) {
            $data = json_decode($response->getBody()->getContents(), true);
            return new JsonResponse($data, JsonResponse::HTTP_OK);
        } else {
            return new JsonResponse(['error' => 'Unable to fetch data from the API'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function setCreatedByUser(string $CreatedByUser): static
    {
        $this->CreatedByUser = $CreatedByUser;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->Status;
    }

    public function setStatus(bool $Status): static
    {
        $this->Status = $Status;

        return $this;
    }
}
