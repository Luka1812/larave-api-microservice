<?php

namespace App\Services;

use App\Support\EntityManager;
use Datetime;
use App\Entities\MessageLog;
use App\Exceptions\SystemException;
use Exception;
use App\Enums\ErrorCodes\SystemErrorCode;
use App\Enums\Entities\MessageLogStatus;

class MessageLogService
{
    /**
     * The Entity Manager instance
     *
     * @var \App\Support\EntityManager
     */
    private $entityManager;

    /**
     * The MessageLog Repository instance
     *
     * @var \App\Repositories\MessageLogRepository
     */
    private $messageLogRepository;

    /**
     * The abstract service constructor.
     *
     * @param  \App\Support\EntityManager $entityManager
     *
     * @return void
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager              = $entityManager;
        $this->messageLogRepository       = $this->entityManager->getRepository(MessageLog::class);
    }

    /**
     * Create message log
     *
     * @param array $data
     * @return \App\Entities\MessageLog $messageLog
     *
     * @throws
     */
    public function create(array $data): MessageLog
    {
        try {
            $callback = function() use ($data) {
                $messageLog = new MessageLog();
                $messageLog->setDirection($data['direction']);
                $messageLog->setIdentifier($data['identifier']);

                if (isset($data['delivery_info'])) {
                    $messageLog->setDeliveryInfo($data['delivery_info']);
                }

                if (isset($data['request'])) {
                    $messageLog->setRequest($data['request']);
                }

                if (isset($data['response'])) {
                    $messageLog->setResponse($data['response']);
                }

                $messageLog->setStatus($data['status']);

                if (isset($data['received_at'])) {
                    $messageLog->setReceivedAt($data['received_at']);
                }

                if (isset($data['processed_at'])) {
                    $messageLog->setProcessedAt($data['processed_at']);
                }

                $this->entityManager->persist($messageLog);

                return $messageLog;
            };

            $messageLog = $this->entityManager->transactional($callback);
        } catch (Exception $exception) {
            throw new SystemException(
                SystemErrorCode::getDescription(SystemErrorCode::ERR_FATAL),
                SystemErrorCode::ERR_FATAL,
                $exception
            );
        }

        return $messageLog;
    }

    /**
     * Update message log
     *
     * @param \App\Entities\MessageLog $messageLog
     * @param array $data
     * @return void
     *
     * @throws
     */
    public function update(MessageLog $messageLog, array $data): void
    {
        try {
            $callback = function() use ($messageLog, $data) {
                if (isset($data['status'])) {
                    $messageLog->setStatus(new MessageLogStatus($data['status']));
                }

                if (isset($data['response'])) {
                    $messageLog->setResponse($data['response']);
                }

                $messageLog->setProcessedAt(new DateTime("now"));

                $this->entityManager->persist($messageLog);

                return $messageLog;
            };

            $this->entityManager->transactional($callback);
        } catch (Exception $exception) {
            throw new SystemException(
                SystemErrorCode::getDescription(SystemErrorCode::ERR_FATAL),
                SystemErrorCode::ERR_FATAL,
                $exception
            );
        }
    }
}
