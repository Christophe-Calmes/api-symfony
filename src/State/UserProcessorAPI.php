<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

// Ajouter
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
// Password Interface
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class UserProcessorAPI implements ProcessorInterface
{
  public function __construct(public readonly  UserPasswordHasherInterface $passwordHasher, public readonly EntityManagerInterface $em) {

  }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        // Affichages des éléments de la fonction process
        // dd($data, $operation, $uriVariables, $context);

        if($data instanceof User == false) {
          //dd($data);
          return;
        }
        $data->setPassword($this->passwordHasher->hashPassword($data, $data->getPassword()));
        //dd($data);
        // Enregistrement dans la DB
        $this->em->persist($data);
        // Vidange de la mémoire
        $this->em->flush();
    }
}
