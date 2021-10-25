<p>Bonjour {{ $userName }},</p>

<p>Le status de la commande #{{ $orderId }} vient de changer a "{{ __('lang.order_status_' . $newStatus) }}".</p>

<p>Il est possible de voir votre commande en consultant la section <a href="{{ route('purchase_orders.index') }}">bons de commandes</a>.</p>

<p>Bonne fin de journée!</p>


<p>Message automatisé par SavonsMy</p>
