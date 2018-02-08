<?php

namespace AppBundle\UseCase;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Form\AlbumType;

class CreateAlbumUseCase
{
    private $templating;
    private $router;
    private $formFactory;
    private $em;
    private $session;

    public function __construct(
        EngineInterface $templating,
        RouterInterface $router,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $em
    )
    {
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->templating = $templating;
        $this->em = $em;
    }


    public function execute(Request $request): Response
    {
        $form = $this->formFactory->create(AlbumType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($form->getData());
            $this->em->flush();
            return $this->onSuccess();
        }

        return $this->templating->renderResponse('album/add-album.html.twig', [
            'form' => $form->createView(),
            ]);

    }

    private function onSuccess(): Response
    {
        return new RedirectResponse($this->router->generate('album_list'));
    }

}

