<p>Bonjour,</p>

<p>Un nouveau bon de commande vient d'être ajouté au système.</p>

<p>Bon de commande #{{ $orderNumber }}</p>
<p>Nom du client: {{ $clientName }}</p>
<p><a href="{{ route('admin.order.view.index', ['orderId' => $orderId]) }}">Cliquer ici pour voir la commande</a></p>


<p>Message automatisé par SavonsMy</p>
