# QuizController

La classe `QuizController` fournit des endpoints pour gérer des questions de quiz et leurs réponses.

## Routes et Utilisation

### 1. Insérer des données depuis une API externe

- **Endpoint:** `/api/quiz/question/remplir` (GET)
  - Cette route récupère des données de questions et de réponses depuis une API externe et les insère dans la base de données.
  - Utilisation: Lorsque vous appelez cette route, elle récupère les données de l'API externe et les insère dans la base de données.

### 2. Récupérer toutes les questions

- **Endpoint:** `/api/quiz/question` (GET)
  - Cette route récupère toutes les données de questions de la base de données et les affiche.
  - Utilisation: Utilisez cette route pour récupérer toutes les questions stockées dans la base de données.

### 3. Récupérer des questions par difficulté

- **Endpoint:** `/api/quiz/question/difficulty/{difficulty}` (GET)
  - Cette route récupère les questions en fonction de la difficulté spécifiée.
  - Utilisation: Remplacez `{difficulty}` par la difficulté souhaitée pour récupérer les questions correspondantes.

### 4. Récupérer des questions par catégorie

- **Endpoint:** `/api/quiz/question/category/{category}` (GET)
  - Cette route récupère les questions en fonction de la catégorie spécifiée.
  - Utilisation: Remplacez `{category}` par la catégorie souhaitée pour récupérer les questions correspondantes.

### 5. Quiz aléatoire

- **Endpoint:** `/api/quiz/random` (GET)
  - Cette route renvoie aléatoirement 10 questions.
  - Utilisation: Utilisez cette route pour obtenir un quiz aléatoire de 10 questions.

### 6. Quiz aléatoire avec sélection

- **Endpoint:** `/api/quiz/random/select` (GET)
  - Cette route renvoie un nombre aléatoire de questions en fonction de la difficulté et de la catégorie spécifiées.
  - Utilisation: Vous pouvez spécifier la difficulté et la catégorie en tant que paramètres de requête pour obtenir un quiz filtré.

### 7. Créer une question

- **Endpoint:** `/api/question` (POST)
  - Cette route crée une nouvelle question avec ses réponses associées.
  - Utilisation: Envoyez une requête POST avec les détails de la question et de ses réponses pour créer une nouvelle question.

### 8. Mettre à jour une question

- **Endpoint:** `/api/question/{id}` (PUT)
  - Cette route met à jour une question existante avec ses réponses associées.
  - Utilisation: Envoyez une requête PUT avec l'ID de la question à mettre à jour et les détails mis à jour de la question et de ses réponses.

### 9. Supprimer une question

- **Endpoint:** `/api/question/delete/{id}` (DELETE)
  - Cette route change le statut d'une question pour la désactiver.
  - Utilisation: Envoyez une requête DELETE avec l'ID de la question à désactiver.
