<?php

namespace App\Domain\DTO;

use Carbon\Carbon;

class OrderDTO
{
    private int $versionId;
    private int $clientId;
    private string $externalUid;
    private string $status;
    private Carbon $sentAt;
    private int $orderId;

    public function __construct(int $versionId, int $clientId, string $externalUid, string $status, Carbon $sent_at, int $orderId = 0)
    {
        $this->orderId = $orderId;
        $this->versionId = $versionId;
        $this->clientId = $clientId;
        $this->externalUid = $externalUid;
        $this->status = $status;
        $this->sentAt = $sent_at;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getExternalUid(): string
    {
        return $this->externalUid;
    }

    /**
     * @return Carbon
     */
    public function getSentAt(): Carbon
    {
        return $this->sentAt;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getVersionId(): int
    {
        return $this->versionId;
    }
}
