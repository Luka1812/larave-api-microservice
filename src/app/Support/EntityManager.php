<?php

namespace App\Support;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\RetryableException;
use Exception;

/**
 * @method \Doctrine\ORM\EntityManager getConnection()
 * @method \Doctrine\ORM\EntityManager getMetadataFactory()
 * @method \Doctrine\ORM\EntityManager getExpressionBuilder()
 * @method \Doctrine\ORM\EntityManager beginTransaction()
 * @method \Doctrine\ORM\EntityManager getCache()
 * @method \Doctrine\ORM\EntityManager commit()
 * @method \Doctrine\ORM\EntityManager rollback()
 * @method \Doctrine\ORM\EntityManager getClassMetadata($className)
 * @method \Doctrine\ORM\EntityManager createQuery($dql = '')
 * @method \Doctrine\ORM\EntityManager createNamedQuery($name)
 * @method \Doctrine\ORM\EntityManager createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
 * @method \Doctrine\ORM\EntityManager createNamedNativeQuery($name)
 * @method \Doctrine\ORM\EntityManager createQueryBuilder()
 * @method \Doctrine\ORM\EntityManager flush($entity = null)
 * @method \Doctrine\ORM\EntityManager find($entityName, $id, $lockMode = null, $lockVersion = null)
 * @method \Doctrine\ORM\EntityManager getReference($entityName, $id)
 * @method \Doctrine\ORM\EntityManager getPartialReference($entityName, $identifier)
 * @method \Doctrine\ORM\EntityManager clear($entityName = null)
 * @method \Doctrine\ORM\EntityManager close()
 * @method \Doctrine\ORM\EntityManager persist($entity)
 * @method \Doctrine\ORM\EntityManager remove($entity)
 * @method \Doctrine\ORM\EntityManager refresh($entity)
 * @method \Doctrine\ORM\EntityManager detach($entity)
 * @method \Doctrine\ORM\EntityManager merge($entity)
 * @method \Doctrine\ORM\EntityManager copy($entity, $deep = false)
 * @method \Doctrine\ORM\EntityManager lock($entity, $lockMode, $lockVersion = null)
 * @method \Doctrine\ORM\EntityManager getRepository($entityName)
 * @method \Doctrine\ORM\EntityManager contains($entity)
 * @method \Doctrine\ORM\EntityManager getEventManager()
 * @method \Doctrine\ORM\EntityManager getConfiguration()
 * @method \Doctrine\ORM\EntityManager isOpen()
 * @method \Doctrine\ORM\EntityManager getUnitOfWork()
 * @method \Doctrine\ORM\EntityManager getHydrator($hydrationMode)
 * @method \Doctrine\ORM\EntityManager newHydrator($hydrationMode)
 * @method \Doctrine\ORM\EntityManager getProxyFactory()
 * @method \Doctrine\ORM\EntityManager initializeObject()
 * @method \Doctrine\ORM\EntityManager create($connection, Configuration $config, EventManager $eventManager = null)
 * @method \Doctrine\ORM\EntityManager getFilters()
 * @method \Doctrine\ORM\EntityManager isFiltersStateClean()
 * @method \Doctrine\ORM\EntityManager hasFilters()
 *
 * @see \Doctrine\ORM\EntityManager
 */
class EntityManager
{
    /**
     * The doctrine orm entity manager instance.
     *
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * The doctrine persistence manager registry instance.
     *
     * @var \Doctrine\Common\Persistence\ManagerRegistry
     */
    private $mr;

    /**
     * Number of retries in transactional method
     *
     * @var int
     */
    private $retries = 10;

    /**
     * Create new entity manager instance.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     * @param \Doctrine\Common\Persistence\ManagerRegistry $mr
     *
     * @return void
     */
    public function __construct(EntityManagerInterface $em, ManagerRegistry $mr)
    {
        $this->em = $em;
        $this->mr = $mr;
    }

    /**
     * Executes a function in a transaction.
     *
     * The function gets passed this EntityManager instance as an (optional) parameter.
     *
     * @param callable $callback
     *
     * @return mixed
     *
     * @throws \Doctrine\DBAL\Exception\RetryableException
     */
    public function transactional(callable $callback)
    {
        $retries = 0;

        do {
            $this->em->beginTransaction();

            try {
                $ret = $callback();

                $this->em->flush();
                $this->em->commit();

                return $ret;
            } catch (RetryableException $e) {
                $this->em->rollback();
                $this->em->close();
                $this->resetManager();

                ++$retries;
            } catch (Exception $e) {
                $this->em->rollback();

                throw $e;
            }
        } while ($retries < $this->retries);

        throw $e;
    }

    /**
     * Resets the entity manager
     *
     * @return void
     */
    public function resetManager()
    {
        $this->em = $this->mr->resetManager();
    }

    /**
     * @param string $name
     * @param mixed $args
     *
     * @return mixed
     */
    public function __call($name, $args)
    {
        return call_user_func_array([$this->em, $name], $args);
    }
}
