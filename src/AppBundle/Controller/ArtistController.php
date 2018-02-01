<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\ArtistType;
use AppBundle\Entity\Artist;
use AppBundle\Entity\Album;

class ArtistController extends Controller
{
    /**
     * @Route("/add-artist/{albumid}", name="add_artist")
     * @ParamConverter("album", options={"mapping"={"albumid"="id"}})
     */
    public function newAction(Request $request, Album $album)
    {

        $artist = new Artist();
        $artist->addAlbum($album);
        $form = $this->createForm(ArtistType::class, $artist);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($artist);
            $em->flush();

            return $this->redirectToRoute('album_list');
        }

        return $this->render('artist/add-artist.html.twig', [
            'form' => $form->createView(),
            ]);
    }

    /**
     * @Route("/delete-artists/{id}/{albumid}", name="delete_artist")
     * @ParamConverter("album", options={"mapping"={"albumid"="id"}})
     */
    public function deleteAction(Artist $artist, Album $album)
    {

        $em = $this->getDoctrine()->getManager();
        $artist->removeAlbum($album);
        $em->persist($artist);

        if(count($artist->getAlbums()) == 0)
        {
            $em->remove($artist);
         }

        $em->flush();

        return $this->redirectToRoute('album_list');
    }
}
