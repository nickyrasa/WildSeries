<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
  #[Route('/', name: 'index')]
  public function index(ProgramRepository $programRepository): Response
  {
    $programs = $programRepository->findAll();
    return $this->render('program/index.html.twig', ['programs' => $programs,]);
  }

  #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['GET'], name: 'show')]
  public function show(int $id, ProgramRepository $programRepository, SeasonRepository $seasonRepository): Response
  {
    $program = $programRepository->find($id);
    $seasons = $program->getSeasons();

    return $this->render('program/show.html.twig', ['program' => $program, 'seasons' => $seasons]);
  }

  #[Route('/{programId}/season/{seasonId}', requirements: ['id' => '\d+'], methods: ['GET'], name: 'show_season')]
  public function showSeason(
    int $programId, 
    int $seasonId, 
    ProgramRepository $programRepository, 
    SeasonRepository $seasonRepository
    ): Response
  {
    $program = $programRepository->find($programId);
    $programCategory = $program->getCategory();
    $season = $seasonRepository->find($seasonId);
    $episodes = $season->getEpisodes();


    return $this->render('program/show_season.html.twig', [
      'program' => $program, 
      'season' => $season,
      'category' => $programCategory,
      'episodes' => $episodes
      ]);
  }

  #[Route('/{programId}/season/{seasonId}/episode/{episodeId}', name: 'episode_show')]
    public function showEpisode(
        #[MapEntity(mapping: ['programId' => 'id'])] Program $program,
        #[MapEntity(mapping: ['seasonId' => 'id'])] Season $season,
        #[MapEntity(mapping: ['episodeId' => 'id'])] Episode $episode
    ) {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
        ]);
    }
}
