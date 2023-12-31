<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;


#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
  #[Route('/', name: 'index')]
  public function index(ProgramRepository $programRepository): Response
  {
    $programs = $programRepository->findAll();
    return $this->render('program/index.html.twig', ['programs' => $programs,]);
  }

  #[Route('/new', name: 'new')]
  public function new(Request $request, EntityManagerInterface $entityManager): Response
  {
    // Create a new Category Object
    $program = new Program();
    // Create the associated Form
    $form = $this->createForm(ProgramType::class, $program);
    // Get data from HTTP request
    $form->handleRequest($request);
    // Was the form submitted ?
    if ($form->isSubmitted() && $form->isValid()) {
      // Deal with the submitted data
      // For example : persiste & flush the entity
      // And redirect to a route that display the result
      $entityManager->persist($program);
      $entityManager->flush();
      // Render the form
      $this->addFlash('success', 'The new program has been created');

      return $this->redirectToRoute('index');
    }

    return $this->render('program/new.html.twig', [
      'form' => $form,
    ]);
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
  ): Response {
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

  #[Route('/{programId}/season/{seasonId}/episode/{episodeId}', name: 'show_episode')]
  public function showEpisode(
    #[MapEntity(mapping: ['programId' => 'id'])] Program $program,
    #[MapEntity(mapping: ['seasonId' => 'id'])] Season $season,
    #[MapEntity(mapping: ['episodeId' => 'id'])] Episode $episode
  ) {
    return $this->render('program/show_episode.html.twig', [
      'program' => $program,
      'season' => $season,
      'episode' => $episode,
    ]);
  }

  #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, Program $program, EntityManagerInterface $entityManager): Response
  {
    $form = $this->createForm(ProgramType::class, $program);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager->flush();
      $this->addFlash('success', 'The new program has been updated');

      return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('program/edit.html.twig', [
      'program' => $program,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'delete', methods: ['POST'])]
  public function delete(Request $request, Program $program, EntityManagerInterface $entityManager): Response
  {
    if ($this->isCsrfTokenValid('delete' . $program->getId(), $request->request->get('_token'))) {
      $entityManager->remove($program);
      $entityManager->flush();

      $this->addFlash('danger', 'The new program has been deleted');
    }

    return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
  }
}
