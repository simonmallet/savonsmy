<?php

namespace App\Mail;

use App\Domain\DTO\OrderDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChange extends Mailable
{
    use Queueable, SerializesModels;

    /** @var OrderDTO */
    protected $orderDTO;

    /** @var string */
    protected $newStatus;

    /** @var string */
    protected $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(OrderDTO $orderDTO, string $name, string $newStatus)
    {
        $this->orderDTO = $orderDTO;
        $this->newStatus = $newStatus;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.orders.status_change')
            ->subject("Mise à jour du status pour la commande #{$this->orderDTO->getOrderId()} [" . __('lang.order_status_' . $this->newStatus) . "]")
            ->with([
                'userName' => $this->name,
                'newStatus' => $this->newStatus,
                'orderId' => $this->orderDTO->getOrderId(),
            ]);
    }
}
