<?php
/**
 * Created by PhpStorm.
 * User: 00010230
 * Date: 24.10.2019
 * Time: 12:06
 */

namespace App\Repository;

use App\Entity\Dog;
use Doctrine\ORM\EntityManagerInterface;


class DogRepository
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Dog::class);
        $this->em = $entityManager;
    }

    /**
     * @return object[]
     */
    public function getAll()
    {
        return $this->repository->findAll();
    }


    /**
     * @param $id
     * @return object|null
     */
    public function getById($id)
    {
        return $this->repository->find($id);
    }


    /**
     * @param $dog
     * @return int
     */
    public function update($dog)
    {
        $this->em->persist($dog);
        $this->em->flush();
        return 1;
    }


    /**
     * @param $dog
     * @return int
     */
    public function delete($dog)
    {
        $this->em->remove($dog);
        $this->em->flush();
        return 1;
    }

}