<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\ExistedArtistType;
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
        $albums = $this->getDoctrine()
            ->getRepository(Album::class)
            ->findAll();

        return $this->render('album/index.html.twig', [
            'albums' => $albums,
        ]);

    }

    /**
     * @Route("/assign-artist/{albumid}", name="assign_artist")
     * @ParamConverter("album", options={"mapping"={"albumid"="id"}})
     */
    public function assignArtistAction(Request $request, Album $album)
    {
        $form = $this->createForm(ExistedArtistType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $artist = $form->get('artists')->getData();
            $artist->addAlbum($album);
            $em->flush();

            return $this->redirectToRoute('album_list');
        }

        return $this->render('album/assign-artist.html.twig', [
            'form' => $form->createView(),
            'album' => $album
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
