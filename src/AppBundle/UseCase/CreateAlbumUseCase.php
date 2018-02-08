<?php

namespace AppBundle\UseCase;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use AppBundle\Repository\AlbumRepositoryInterface;
use AppBundle\Form\AlbumType;

class CreateAlbumUseCase
{
    private $templating;
    private $router;
    private $formFactory;
    private $repository;
    private $session;

    public function __construct(
        EngineInterface $templating,
        RouterInterface $router,
        FormFactoryInterface $formFactory,
        AlbumRepositoryInterface $repository
    )
    {
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->templating = $templating;
        $this->repository = $repository;
    }


    public function execute(Request $request): Response
    {
        $form = $this->formFactory->create(AlbumType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->save($form->getData());
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

