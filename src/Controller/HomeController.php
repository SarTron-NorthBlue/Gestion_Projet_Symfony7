<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(TaskRepository $taskRepository): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Si l'utilisateur n'est pas connecté, on refuse l'accès
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Récupérer les tâches assignées à cet utilisateur
        $tasks = $taskRepository->findBy(['user' => $user]);

        // Vérification de l'existence de $tasks
        if (!isset($tasks)) {
            $tasks = []; // Définit une valeur par défaut si aucune tâche n'est trouvée
        }

        // Rendre le template et passer les tâches
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'tasks' => $tasks, // Passe les tâches au template
        ]);
    }
}
