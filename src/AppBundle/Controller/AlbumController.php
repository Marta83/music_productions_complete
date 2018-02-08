<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use AppBundle\Command\CreateAlbumCommand;
use AppBundle\UseCase\CreateAlbumUseCase;
use AppBundle\Form\AlbumType;
use AppBundle\Entity\Album;

class AlbumController extends Controller
{
    /**
     * @var MessageBus
     */
    private $messageBus;

    public function __construct(CommandBus $messageBus)
    {
        $this->messageBus = $messageBus;

    }

    /**
     * @Route("/create-album", name="create_album")
     */
    public function createAction(Request $request, CreateAlbumUseCase $createAlbumUseCase)
    {

        $form = $this->createForm(AlbumType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
         $title = $data['title'];
         $published_at = $data['published_at'];

         $command = new CreateAlbumCommand($title, $published_at);

         $this->messageBus->handle($command);
        }
        return $this->redirectToRoute('album_list');

    }

    /**
     * @Route("/new-album", name="new_album")
     */
    public function newAction(Request $request, CreateAlbumUseCase $createAlbumUseCase)
    {
        return $createAlbumUseCase->execute($request);
    }

    /**
     * @Route("/", name="album_list")
     */
    public function listAction(Request $request)
    {
        $albums = $this->getDoctrine()
            ->getRepository(Album::class)
            ->findAll();

        return $this->render('album/index.html.twig', [
            'albums' => $albums,
        ]);

    }

    /**
     * @Route("/delete-album/{id}", name="delete_album")
     */
    public function deleteAction(Album $album)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($album);
        $em->flush();

        return $this->redirectToRoute('album_list');
    }
}
