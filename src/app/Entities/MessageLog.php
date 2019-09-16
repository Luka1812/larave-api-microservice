<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Enums\Entities\MessageLogStatus;
use DateTime;

/**
 * @ORM\Table(name="message_log")
 * @ORM\Entity(repositoryClass="App\Repositories\MessageLogRepository")
 */
class MessageLog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=24, nullable=true)
     *
     * @var string
     */
    private $direction;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     *
     * @var string
     */
    private $identifier;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $deliveryInfo;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $request;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $response;

    /**
     * @ORM\Column(type="enum_message_log_status", nullable=false, length=50)
     *
     * @var \App\Enums\Entities\MessageLogStatus
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var string
     */
    private $receivedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var string
     */
    private $processedAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     */
    public function setDirection(string $direction): void
    {
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getDeliveryInfo(): ?string
    {
        return $this->deliveryInfo;
    }

    /**
     * @param string $deliveryInfo
     */
    public function setDeliveryInfo(?string $deliveryInfo): void
    {
        $this->deliveryInfo = $deliveryInfo;
    }

    /**
     * @return string
     */
    public function getRequest(): ?string
    {
        return $this->request;
    }

    /**
     * @param string $request
     */
    public function setRequest(?string $request): void
    {
        $this->request = $request;
    }

    /**
     * @return string
     */
    public function getResponse(): ?string
    {
        return $this->response;
    }

    /**
     * @param string $response
     */
    public function setResponse(?string $response): void
    {
        $this->response = $response;
    }

    /**
     * @return \App\Enums\Entities\MessageLogStatus
     */
    public function getStatus(): MessageLogStatus
    {
        return $this->status;
    }

    /**
     * @param \App\Enums\Entities\MessageLogStatus $status
     */
    public function setStatus(MessageLogStatus $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getReceivedAt(): string
    {
        return $this->receivedAt;
    }

    /**
     * @param DateTime $receivedAt
     */
    public function setReceivedAt(?DateTime $receivedAt): void
    {
        $this->receivedAt = $receivedAt;
    }

    /**
     * @return DateTime
     */
    public function getProcessedAt(): ?string
    {
        return $this->processedAt;
    }

    /**
     * @param DateTime $processedAt
     */
    public function setProcessedAt(?DateTime $processedAt): void
    {
        $this->processedAt = $processedAt;
    }
}
