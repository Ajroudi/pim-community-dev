<?php

declare(strict_types=1);

namespace Akeneo\Bundle\BatchQueueBundle\Hydrator;

use Akeneo\Component\BatchQueue\Queue\JobExecutionMessage;
use Akeneo\Component\StorageUtils\Factory\SimpleFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use \Doctrine\DBAL\Types\Type;

/**
 * Hydrates a JobExecutionMessage from an array.
 *
 * @author    Alexandre Hocquard <alexandre.hocquard@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class JobExecutionMessageHydrator
{
    /** @var OptionsResolver */
    protected $resolver;

    /** @var  EntityManagerInterface */
    protected $entityManager;

    /** @var SimpleFactoryInterface */
    protected $jobExecutionmessageFactory;

    public function __construct(EntityManagerInterface $entityManager, SimpleFactoryInterface $jobExecutionMessageFactory)
    {
        $this->entityManager = $entityManager;
        $this->jobExecutionmessageFactory = $jobExecutionMessageFactory;
        $this->resolver = new OptionsResolver();
        $this->configureOptions($this->resolver);
    }

    /**
     * @param array $row
     *
     * @throws MissingOptionsException
     *
     * @return JobExecutionMessage
     */
    public function hydrate(array $row): JobExecutionMessage
    {
        $this->resolver->resolve($row);

        $platform = $this->entityManager->getConnection()->getDatabasePlatform();

        $id = Type::getType(Type::INTEGER)->convertToPhpValue($row['id'], $platform);
        $jobExecutionId = Type::getType(Type::INTEGER)->convertToPhpValue($row['job_execution_id'], $platform);
        $options = Type::getType(Type::JSON_ARRAY)->convertToPhpValue($row['options'], $platform);
        $createTime = Type::getType(Type::DATETIME)->convertToPhpValue($row['create_time'], $platform);
        $updatedTime = Type::getType(Type::DATETIME)->convertToPhpValue($row['updated_time'], $platform);
        $consumer = Type::getType(Type::STRING)->convertToPhpValue($row['consumer'], $platform);

        $jobExecutionMessage = $this->jobExecutionmessageFactory->create();
        $jobExecutionMessage
            ->setId($id)
            ->setJobExecutionId($jobExecutionId)
            ->setOptions($options);

        if (null !== $createTime) {
            $jobExecutionMessage->setCreateTime($createTime);
        }

        if (null !== $updatedTime) {
            $jobExecutionMessage->setUpdatedTime($updatedTime);
        }

        if (null !== $consumer) {
            $jobExecutionMessage->setConsumer($consumer);
        }

        return $jobExecutionMessage;
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['id', 'job_execution_id', 'options', 'create_time', 'updated_time', 'consumer']);
    }
}
