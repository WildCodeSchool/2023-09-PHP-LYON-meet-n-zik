<?php

namespace App\Controller;

use App\Model\MatchManager;

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


    private function denyAccessUnlessLoggedIn(): void
    {
    }

    private function isUserPartOfMatch(int $matchId, int $userId): bool
    {
    }
}
