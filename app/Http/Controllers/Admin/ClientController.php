<?php

namespace App\Http\Controllers\Admin;

use App\Domain\BO\OrderBO;
use App\Domain\DAO\ClientDAO;
use App\Domain\DAO\UserDAO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.clients.index')
            ->with('clients', $this->clientDAO->fetchList());
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addIndex()
    {
        return view('admin.clients.add.index')
            ->with('clients', $this->clientDAO->fetchList());
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addSubmit(ClientRequest $request)
    {
        $this->clientDAO->addOrUpdateClientInfo(
            new Client(),
            $request->get('name'),
            $request->get('address'),
            $request->get('phone_number'),
            $request->get('email'),
            (float) $request->get('discount_from_retail')
        );

        /** @todo: Faire une methode helper pour les messages */
        Session::flash('status', 'Client ajouté avec succès!');
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('admin.clients.index');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function updateIndex(int $clientId)
    {
        try {
            $client = $this->clientDAO->fetchInfo($clientId);
        } catch (\Exception $e) {
            Session::flash('status', "Oops! Le client #{$clientId} n'a pu être retrouvé");
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('admin.clients.index');
        }
        return view('admin.clients.update.index')
            ->with('page_title_arguments', ['clientId' => $client->id])
            ->with('client', $client);
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function updateSubmit(int $clientId, ClientRequest $request)
    {
        try {
            $client = $this->clientDAO->fetchInfo($clientId);
        } catch (\Exception $e) {
            Session::flash('status', "Oops! Le client #{$clientId} n'a pu être retrouvé");
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('admin.clients.index');
        }

        $this->clientDAO->addOrUpdateClientInfo(
            $client,
            $request->get('name'),
            $request->get('address'),
            $request->get('phone_number'),
            $request->get('email'),
            (float) $request->get('discount_from_retail')
        );

        /** @todo: Faire une methode helper pour les messages */
        Session::flash('status', 'Client modifié avec succès!');
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('admin.clients.index');
    }
}
