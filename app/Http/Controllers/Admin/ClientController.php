<?php

namespace App\Http\Controllers\Admin;

use App\Domain\BO\OrderBO;
use App\Domain\DAO\ClientDAO;
use App\Domain\DAO\UserDAO;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    private ClientDAO $clientDAO;
    private UserDAO $userDAO;

    public function __construct(ClientDAO $clientDAO, UserDAO $userDAO)
    {
        $this->clientDAO = $clientDAO;
        $this->userDAO = $userDAO;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.clients.index')
            ->with('clients', $this->clientDAO->fetchList());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addIndex()
    {
        return view('admin.clients.add.index')
            ->with('clients', $this->clientDAO->fetchList());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addSubmit(Request $request)
    {
        $client = new Client();
        $client->name = $request->get('name');
        $client->address = $request->get('address');
        $client->phone_number = $request->get('phone_number');
        $client->email = $request->get('email');
        $client->discount_from_retail = (int) $request->get('discount_from_retail');
        $client->save();

        /** @todo: Faire une methode helper pour les messages */
        Session::flash('status', 'Client ajouté avec succès!');
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('admin.clients.index');
    }
}
