<?php

namespace App\Domain\BO;

use App\Constants\HTMLConst;
use App\Constants\OrderStatus;
use App\Domain\DAO\ClientDAO;
use App\Domain\DAO\ConfigDAO;
use App\Domain\DAO\OrderDAO;
use App\Domain\DTO\OrderDTO;
use App\Mail\NewPurchaseOrder;
use App\Mail\OrderStatusChange;
use Illuminate\Support\Facades\Mail;

class OrderTransitionBO
{
    private OrderDAO $orderDAO;
    private ClientDAO $clientDAO;
    private ConfigDAO $configDAO;

    public function __construct(OrderDAO $orderDAO, ClientDAO $clientDAO, ConfigDAO $configDAO)
    {
        $this->orderDAO = $orderDAO;
        $this->clientDAO = $clientDAO;
        $this->configDAO = $configDAO;
    }

    public function getAvailableTransitions(string $currentStatus): array
    {
        $this->isValidStatus($currentStatus);

        return OrderStatus::TRANSITIONS[$currentStatus];
    }

    public function updateOrderStatus(OrderDTO $orderDTO, string $newStatus)
    {
        $this->isValidStatus($newStatus);

        $this->orderDAO->updateStatus($orderDTO, $newStatus);

        foreach ($this->clientDAO->fetchInfo($orderDTO->getClientId())->users as $user) {
            if ($this->configDAO->getConfigInfo('RECEIVE_EMAIL_WHEN_ORDER_STATUS_CHANGE', $user->id) === HTMLConst::CHECKBOX_CHECKED) {
                Mail::to($user->email)->send(new OrderStatusChange($orderDTO, $user->name, $newStatus));
            }
        }
    }

    private function isValidStatus(string $status)
    {
        if (!in_array($status, OrderStatus::STATUSES)) {
            throw new \InvalidArgumentException($status . ' is not a valid status');
        }
        return true;
    }
}
