<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\AlbumType;
use AppBundle\Entity\Album;

class AlbumController extends Controller
{
    /**
     * @Route("/add-album", name="add_album")
     */
    public function newAction(Request $request)
    {

        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($album);
            $em->flush();

            return $this->redirectToRoute('album_list');
        }

        return $this->render('album/add-album.html.twig', [
            'form' => $form->createView(),
            ]);
    }

    /**
     * @Route("/", name="album_list")
     */
    public function listAction(Request $request)
    {
        return new Response();
    }
}
