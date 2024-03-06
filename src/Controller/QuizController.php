<?php

namespace App\Controller;
use OpenApi\Annotations as OA;
use App\Repository\QuestionCreateByUsersRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\QuestionCreateByUsers;
use App\Entity\Question;
use App\Entity\Answer;
use Faker\Factory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Question\Question as QuestionQuestion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use GuzzleHttp\Client;
use App\Controller\QuizController\getDataFromApi;
use App\Repository\QuestionRepository;
use Symfony\Component\Security\Core\Util\SecureRandom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class QuizController extends AbstractController
{
    #[Route('/quiz', name: 'app_quiz')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/QuizController.php',
        ]);
    }
/**
 * @OA\Get(
 *     path="/api/quiz/question/remplir",
 *     summary="Insère des données de questions et de réponses depuis une API externe dans la base de données.",
 *     tags={"Quiz"},
 *     description="Cette fonction envoie une requête GET à une API externe, récupère les données JSON, les transforme en objets Question et Answer, puis les insère dans la base de données.",
 *     operationId="insertQuizData",
 *     @OA\Response(
 *         response=200,
 *         description="Retourne une réponse JSON indiquant le succès de l'insertion des données."
 *     ),
 * )
*/ 
    #[Route('/api/quiz/question/remplir', name:"question.insert", methods:["GET"])]

    public function insertData(EntityManagerInterface $entityManager) : JsonResponse
    {
        $apiUrl = 'https://quizzapi.jomoreschi.fr/api/v1/quiz';
 
        $client = new Client();
        $response = $client->get($apiUrl);

        $statusCode = $response->getStatusCode();
        $data = json_decode($response->getBody()->getContents(), true);

        foreach ($data['quizzes'] as $quizData) {
            if (isset($quizData['_id'])) {
                $question = new Question();
                $question->setJomoreschiId($quizData['_id']);
                $question->setQuestion($quizData['question']);
                $question->setCategory($quizData['category']);
                $question->setDifficulty($quizData['difficulty']);
                $entityManager->persist($question);
                foreach ($quizData["badAnswers"] as $answerKey => $answerValue) {
                    $answer = new Answer();
                    $answer->setRelatedQuestion($question);
                    $answer->setSentence($answerValue);
                    $answer->setIsGood(false);
                    $entityManager->persist($answer);
                }

                $answer = new Answer();
                $answer->setRelatedQuestion($question);
                $answer->setSentence($quizData["answer"]);
                $answer->setIsGood(true);
                $entityManager->persist($answer);
            }
        }
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
    /**
 * @OA\Get(
 *     path="/api/quiz/question",
 *     summary="Affiches les données",
 *     tags={"Quiz"},
 *     description="Cette fonction Récupère toutes les données de la base de données et les affiches.",
 *     @OA\Response(
 *         response=200,
 *         description="Retourne une réponse JSON indiquant le succès de l'insertion des données."
 *     ),
 * )
*/ 
    #[Route('/api/quiz/question', name: "question.getAll", methods: ["GET"])]

    public function getAllQuestions(QuestionRepository $repository, SerializerInterface $serializer){
        
        $jsonData = $serializer->serialize($repository->findAll(), 'json', ['groups' => "getAllQuestions"]);

        return new JsonResponse($jsonData, 200, [], true);
    }
      /**
 * @OA\Get(
 *     path="/api/quiz/question/difficulty/{difficulty}",
 *     summary="Affiches les données en fonction de la difficulté",
 *     tags={"Quiz"},
 *     description="Cette fonction Récupère les données en fonction de la valeur donnée,dans la base de données et les affiches.",
 *     @OA\Response(
 *         response=200,
 *         description="Retourne une réponse JSON indiquant le succès de l'insertion des données."
 *     ),
 * )
*/ 
    #[Route('/api/quiz/question/difficulty/{difficulty}', name:"question.getByDifficulty", methods: ["GET"])]
    
    public function getByDifficulty($difficulty, QuestionRepository $repository, SerializerInterface $serializer) {
        $questions = $repository->findBy(["difficulty"=>$difficulty]);  
        
        $jsonData = $serializer->serialize($questions, 'json', ['groups' => "getAllQuestions"]);

        return new JsonResponse($jsonData, 200, [], true);

   
    }      
     /**
 * @OA\Get(
 *     path="/api/quiz/question/category/{category}",
 *     summary="Affiches les données en fonction de la categorie choisie",
 *     tags={"Quiz"},
 *     description="Cette fonction Récupère les données en fonction de la valeur donnée,dans la base de données et les affiches.",
 *     @OA\Response(
 *         response=200,
 * description="Retourne une réponse JSON indiquant le succès de l'insertion des données."
 *     ),
 * )
*/ 
    #[Route('/api/quiz/question/category/{category}', name:"question.getByCategory", methods: ["GET"])]
    public function getByCategory($category, QuestionRepository $repository, SerializerInterface $serializer) {
        $questions = $repository->findBy(["category"=>$category]);
        
        $jsonData = $serializer->serialize($questions, 'json', ['groups' => "getAllQuestions"]);

        return new JsonResponse($jsonData, 200, [], true);
    }
       /**
 * @OA\Get(
 *     path="/api/quiz/random",
 *     summary="Quiz Random",
 *     tags={"Quiz"},
 *     description="Cette fonction Récupère les données et renvoie aleatoirement 10 questions.",
 *     @OA\Response(
 *         response=200,
 *         description="Retourne une réponse JSON indiquant le succès de l'insertion des données."
 *     ),
 * )
*/  
    #[Route("/api/quiz/random", name:"question.random", methods: ["GET"])]
    public function randomQuiz(QuestionRepository $repository, SerializerInterface $serializer): JsonResponse
    {
     $allQuestions = $repository->findAll();
     shuffle($allQuestions);
     $selectedQuestions = array_slice($allQuestions, 0, 10);
     $jsonQuestions = $serializer->serialize($selectedQuestions, 'json',['groups' => "getAllQuestions"]);
     $response = new JsonResponse($jsonQuestions, 200, [], true);
     return $response;
    }

           /**
 * @OA\Get(
 *     path="/api/quiz/random/select",
 *     summary="Quiz Random avec argument",
 *     tags={"Quiz"},
 *     description="Cette fonction Récupère les données et renvoie un nombre aleatoire de question en fonction de la difficulté et la categorie renseigné.",
 *     @OA\Response(
 *         response=200,
 *         description="Retourne une réponse JSON indiquant le succès de l'insertion des données."
 *     ),
 * )
*/ 
#[Route('/api/quiz/random/select', name:'question.randomselect', methods: ['GET'])]
public function randomFilterQuiz(Request $request, QuestionRepository $repository, SerializerInterface $serializer): JsonResponse
   {
        $difficulty = $request->query->get('difficulty', null);
        $category = $request->query->get('category', null);
        $numberOfQuestions = $request->query->get('numberOfQuestions', 10); // Par défaut 10 questions

        $criteria = [];

        if ($difficulty !== null) {
            $criteria['difficulty'] = $difficulty;
        }

        if ($category !== null) {
            $criteria['category'] = $category;
        }

        $filteredQuestions = $repository->findBy($criteria);
        shuffle($filteredQuestions);
        $selectedQuestions = array_slice($filteredQuestions, 0, $numberOfQuestions);

        $jsonQuestions = $serializer->serialize($selectedQuestions, 'json', ['groups' => "getAllQuestions"]);
        
         
        return new JsonResponse($jsonQuestions, 200, [], true);
        
    }
               /**
 * @OA\Post(
 *     path="/api/question",
 *     summary="Creer une question",
 *     tags={"Quiz"},
 *     description="Cette fonction creer une question et ces reponses",
 *     @OA\Response(
 *         response=200,
 *         description="Retourne une réponse JSON indiquant le succès de l'insertion des données."
 *     ),
 * )
*/ 
    #[Route('/api/question', name: 'question.create', methods: ['POST'])]
    public function createQuestion(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager): JsonResponse
    {
        $questionData = json_decode($request->getContent(), true);
        $faker = Factory::create();
        $randomString = $faker->regexify('[A-Za-z0-9]{' . mt_rand(5, 20) . '}');
    
        $question = new Question();
        $question->setQuestion($questionData['question']);
        $question->setCategory($questionData['category']);
        $question->setDifficulty($questionData['difficulty']);
        $question->setIsCreatedByUsers(true);
        $question->setStatus("on");
        $question->setJomoreschiId($randomString);
        $manager->persist($question);
    
        $answersData = $questionData['answers'];
        foreach ($answersData as $answerData) {
            $answer = new Answer();
            $answer->setSentence($answerData['sentence']);
            $answer->setIsGood($answerData['isGood']);
            $answer->setRelatedQuestion($question);
            $answer->setQuestion($question);
            $manager->persist($answer);
        }
    
        $manager->flush();
        $jsonQuestion = $serializer->serialize($question, 'json', ['groups' => 'getAllQuestions']);
    
        return new JsonResponse($jsonQuestion, Response::HTTP_OK, [], true);
    }
               /**
 * @OA\Put(
 *     path="/api/question/{id}",
 *     summary="Modifier une question",
 *     tags={"Quiz"},
 *     description="Cette fonction modifie une question et ces reponses",
 *     @OA\Response(
 *         response=200,
 *         description="Retourne une réponse JSON indiquant le succès de l'insertion des données."
 *     ),
 * )
*/ 
    #[Route('/api/question/{id}', name: 'question.update', methods: ['PUT'])]
public function updateQuestion(int $id, Request $request, EntityManagerInterface $manager): JsonResponse
{
    $question = $manager->getRepository(Question::class)->find($id);

    if (!$question) {
        return new JsonResponse(['message' => 'Question not found'], Response::HTTP_NOT_FOUND);
    }
    $requestData = json_decode($request->getContent(), true);
    $question->setQuestion($requestData['question'] ?? $question->getQuestion());
    $question->setCategory($requestData['category'] ?? $question->getCategory());
    $question->setDifficulty($requestData['difficulty'] ?? $question->getDifficulty());
    if (isset($requestData['answers']) && is_array($requestData['answers'])) {
        foreach ($requestData['answers'] as $answerData) {
            $answerId = $answerData['id'] ?? null;
            if ($answerId) {
                $answer = $manager->getRepository(Answer::class)->find($answerId);
                if ($answer) {
                    $answer->setSentence($answerData['sentence'] ?? $answer->getSentence());
                    $answer->setIsGood($answerData['isGood'] ?? $answer->isIsGood());
                    $manager->persist($answer);
                }
            }
        }
    }

    $manager->flush();

    return new JsonResponse(['message' => 'Question updated successfully'], Response::HTTP_OK);
}
               /**
 * @OA\Delete(
 *     path="/api/question/delete/{id}",
 *     summary="Modifier une question",
 *     tags={"Quiz"},
 *     description="Cette fonction modifie une question et ces reponses",
 *     @OA\Response(
 *         response=200,
 *         description="Retourne une réponse JSON indiquant le succès de l'insertion des données."
 *     ),
 * )
*/
    #[Route('/api/question/delete/{id}', name: 'question.delete', methods: ['DELETE'])]
public function deleteQuestion(int $id, EntityManagerInterface $manager): JsonResponse
{
    $question = $manager->getRepository(Question::class)->find($id);
    $question->setStatus('off');
    $manager->flush();

    return new JsonResponse(['message' => 'Question status set to off'], Response::HTTP_OK);
}


}
