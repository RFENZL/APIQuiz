<?php

namespace App\Controller;

use Ramsey\Uuid\Uuid;
use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionController extends AbstractController
{
    #[Route('/question', name: 'app_question')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/QuestionController.php',
        ]);
    }
    #[Route('/api/question', name: 'question.create', methods: ['POST'])]
    public function createQuestion(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager): JsonResponse
    {
        $questionData = json_decode($request->getContent(), true);
    
        // Extraction des données de la question
        $question = new Question();
        $question->setQuestion($questionData['question']);
        $question->setCategory($questionData['category']);
        $question->setDifficulty($questionData['difficulty']);
        
        // Générer un UUID aléatoire pour jomoreschiId
        $jomoreschiId = Uuid::uuid4()->toString();
        $question->setJomoreschiId($jomoreschiId);
        
        $question->setIsCreatedByUsers(true);
        $manager->persist($question);
    
        // Extraction des données des réponses
        $answersData = $questionData['answers'];
        foreach ($answersData as $answerData) {
            $answer = new Answer();
            $answer->setSentence($answerData['sentence']);
            $answer->setSentence($answerData['sentence']);
            $answer->setIsGood($answerData['isGood']);
            $answer->setQuestion($question);
            $manager->persist($answer);
        }
    
        $manager->flush();
        // $cache->invalidateTags(['questionCache']);
    
        // Serialize la question avec ses réponses
        $jsonQuestion = $serializer->serialize($question, 'json', ['groups' => 'getAllQuestions']);
    
        return new JsonResponse($jsonQuestion, Response::HTTP_OK, [], true);
    }
}
