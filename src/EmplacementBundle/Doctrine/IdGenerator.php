<?php


namespace EmplacementBundle\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints\Uuid

/**
 * {@inheritdoc}
 */
class IdGenerator extends AbstractIdGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generate(EntityManager $em, $entity)
    {
        $uuid = Uuid::uuid4()->getHex();

        if (null !== $em->getRepository(get_class($entity))->findOneBy(['id' => $uuid])) {
            $uuid = $this->generate($em, $entity);
        }

        return $uuid;
    }
}
