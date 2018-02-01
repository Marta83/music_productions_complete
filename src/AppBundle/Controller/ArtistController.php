<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\ArtistType;
use AppBundle\Entity\Contribution;
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
        $form = $this->createForm(ArtistType::class, $artist);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fee = $form->get('fee')->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($artist);


            $contribution = new Contribution();
            $contribution->setAlbum($album);
            $contribution->setArtist($artist);
            $contribution->setFee($fee);
            $em->persist($contribution);

            $em->flush();

            return $this->redirectToRoute('album_list');
        }

        return $this->render('artist/add-artist.html.twig', [
            'form' => $form->createView(),
            'album' => $album
            ]);
    }

    /**
     * @Route("/delete-artists/{contributionid}", name="delete_artist")
     * @ParamConverter("contribution", options={"mapping"={"contributionid"="id"}})
     */
    public function deleteAction(Contribution $contribution)
    {
        $artist = $contribution->getArtist();
        $em = $this->getDoctrine()->getManager();
        $em->remove($contribution);

        if(count($artist->getContributions()) == 0)
        {
            $em->remove($artist);
         }

        $em->flush();

        return $this->redirectToRoute('album_list');
    }
}
