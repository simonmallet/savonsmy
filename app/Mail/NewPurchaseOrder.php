<?php

namespace App\Mail;

use App\Domain\DAO\ClientDAO;
use App\Domain\DTO\OrderDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPurchaseOrder extends Mailable
{
    use Queueable, SerializesModels;

    /** @var OrderDTO */
    protected $orderDTO;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(OrderDTO $orderDTO)
    {
        $this->orderDTO = $orderDTO;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        /** @var ClientDAO $clientDAO */
        $clientDAO = app(ClientDAO::class);
        $client = $clientDAO->fetchInfo($this->orderDTO->getClientId());

        return $this->view('emails.purchase_order.new')
            ->subject("Nouvelle commande de [{$client->name}] [#{$this->orderDTO->getOrderId()}]")
            ->with([
                'clientName' => $client->name,
                'orderNumber' => $this->orderDTO->getOrderId(),
                'orderId' => $this->orderDTO->getOrderId(),
            ]);
    }
}
