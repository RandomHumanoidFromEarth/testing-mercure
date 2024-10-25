<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\OwnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    public function __construct(private readonly OwnerRepository $ownerRepository)
    {
    }

    #[Route('/', 'index')]
    public function index(Request $request): Response
    {
        return $this->render('index.twig', [
            'owners' => $this->ownerRepository->findAll(),
            'topic' => match ($request->query->has('owner')) {
                true => "{$request->query->get('owner')}/puppies/*",
                default => '*',
            },
        ]);
    }
}
