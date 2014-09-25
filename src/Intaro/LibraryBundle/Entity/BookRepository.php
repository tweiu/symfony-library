<?php

namespace Intaro\LibraryBundle\Entity;

use Doctrine\ORM\EntityRepository;

class BookRepository extends EntityRepository
{
    /**
     * Returns book list, ordered by date of reading, desc
     */
    public function findAllOrderedByDateOfReading()
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT b
                FROM IntaroLibraryBundle:Book b
                ORDER BY b.readAt DESC"
            )
            ->useResultCache(true, 86400, "books")
            ->getResult();
    }
}
