<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use DateTimeImmutable;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Service\ImageService;
use App\Repository\TrickRepository;
use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/trick')]
class TrickController extends AbstractController
{
    #[Route('/', name: 'app_trick_index', methods: ['GET'])]
    public function index(TrickRepository $trickRepository): Response
    {
        return $this->render('trick/index.html.twig', [
            'tricks' => $trickRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_trick_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TrickRepository $trickRepository, ImageService $imageService): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            // On récupère les images transmises
            $images = $form->get('images')->getData();
            $name = $form->get('name')->getData();
            $imageService->add($images, $trick, $this->getParameter('images_directory'));

            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($name);
            
            $trick->setSlug($slug);
            $trick->setUser($user);
            $trickRepository->save($trick, true);

            $this->addFlash('success', 'La figure a été créée avec succès!');
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_trick_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Trick $trick, CommentRepository $commentRepository, PaginatorInterface $paginator): Response
    {

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $user = $this->getuser();

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setTrick($trick);
            $comment->setUser($user);
            $date = new DateTimeImmutable();
            $comment->setCreatedAt($date);
            $commentRepository->save($comment, true);
            return $this->redirectToRoute('app_trick_show', ['slug' => $trick->getSlug() ], Response::HTTP_SEE_OTHER);
        }
        $donnees = $commentRepository->findBy(array('trick' => $trick),array('createdAt' => 'DESC'));
        $comments = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10 // Nombre de résultats par page
        );
        return $this->renderForm('trick/show.html.twig', [
            'trick' => $trick,
            'comments' =>  $comments,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_trick_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trick $trick, TrickRepository $trickRepository, ImageService $imageService): Response
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $images = $form->get('images')->getData();
            $imageService->add($images, $trick, $this->getParameter('images_directory'));
            $trickRepository->save($trick, true);

            return $this->redirectToRoute('app_trick_edit', ['id' => $trick->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_trick_delete', methods: ['POST'])]
    public function delete(Request $request, Trick $trick, TrickRepository $trickRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $trickRepository->remove($trick, true);
        }
        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
    }
}
