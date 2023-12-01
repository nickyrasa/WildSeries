<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;

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
    $seasons = $seasonRepository->find($id);
    return $this->render('program/show.html.twig', ['program' => $program, 'seasons' => $seasons]);
  }

  #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['GET'], name: 'program_season_show')]
  public function showSeason(int $id, ProgramRepository $programRepository, SeasonRepository $seasonRepository): Response
  {
    $program = $programRepository->find($id);
    $seasons = $seasonRepository->find($id);
    return $this->render('program/show_season.html.twig', ['program' => $program, 'seasons' => $seasons]);
  }
}
