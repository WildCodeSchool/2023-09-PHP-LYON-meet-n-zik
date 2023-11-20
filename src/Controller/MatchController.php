<?php

namespace App\Controller;

use App\Model\MatchManager;
use App\Model\UserManager;

class MatchController extends AbstractController
{
    public function index(): string
    {
        $this->denyAccessUnlessLoggedIn();

        $matchManager = new MatchManager();
        $userId = $this->getUser()->getId();

        $matches = $matchManager->getUserMatches($userId);

        return $this->twig->render('Match/index.html.twig', ['matches' => $matches]);
    }

    public function show(int $matchId): string
    {
        $this->denyAccessUnlessLoggedIn();

        $matchManager = new MatchManager();
        $match = $matchManager->selectOneById($matchId);

        if (!$this->isUserPartOfMatch($matchId, $this->getUser()->getId())) {
            throw new \Exception("Vous n'avez pas la permission de voir ce match.");
        }


        return $this->twig->render('Match/show.html.twig', ['match' => $match /* , 'messages' => $messages */]);
    }


   public function denyAccessUnlessLoggedIn(): void
    {
    }

   public function isUserPartOfMatch(int $matchId, int $userId): bool
    {
    }
    
    public function addMatch(int $targetId) 
    {
        $userManager = new UserManager();
        $userManager->likedAsHost($_SESSION['user_id'], $targetId);
        // $userManager->selectAllBand();
        echo $_SESSION['user_id'];
    }
}
