<?php

declare(strict_types=1);

namespace App\Messenger;

use ApiPlatform\Metadata\IriConverterInterface;
use App\Entity\Puppy;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[AsMessageHandler]
readonly class PuppyNotificationHandler
{
    public function __construct(
        private SerializerInterface $serializer,
        private EntityManagerInterface $entityManager,
        private IriConverterInterface $iriConverter,
        private HubInterface $hub,
    ) {
    }


    public function __invoke(Puppy $puppy): void
    {
        $this->entityManager->flush();
        $this->entityManager->refresh($puppy);
        $update = new Update(
            $this->iriConverter->getIriFromResource($puppy),
            $this->serializer->serialize($puppy, 'json'),
        );
        $this->hub->publish($update);
    }
}
