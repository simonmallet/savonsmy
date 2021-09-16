<?php

namespace App\Http\Controllers\Admin;

use App\Domain\BO\OrderBO;
use App\Domain\DAO\ClientDAO;
use App\Domain\DAO\UserDAO;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private OrderBO $orderBO;
    private UserDAO $userDAO;
    private ClientDAO $clientDAO;

    public function __construct(OrderBO $orderBO, UserDAO $userDAO, ClientDAO $clientDAO)
    {
        $this->orderBO = $orderBO;
        $this->userDAO = $userDAO;
        $this->clientDAO = $clientDAO;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function assignClientIndex(int $userId)
    {
        try {
            $user = $this->userDAO->fetchInfo($userId);
        } catch (ModelNotFoundException $e) {
            Session::flash('message', "Oops! L'utilisateur #{$userId} n'a pu être retrouvé");
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('admin.dashboard');
        }
        return view('admin.users.assign_client')->with('user', $user)->with('clients', $this->clientDAO->fetchList());
    }

    public function assignClientSubmit(int $userId, Request $request)
    {
        try {
            $user = $this->userDAO->fetchInfo($userId);
        } catch (ModelNotFoundException $e) {
            Session::flash('message', "Oops! L'utilisateur #{$userId} n'a pu être retrouvé");
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('admin.dashboard');
        }

        $this->userDAO->assignToClient($user, $request->get('client'));

        return redirect()->route('admin.dashboard');
    }

    public function approveSubmit(int $userId)
    {
        try {
            $user = $this->userDAO->fetchInfo($userId);
        } catch (ModelNotFoundException $e) {
            Session::flash('message', "Oops! L'utilisateur #{$userId} n'a pu être retrouvé");
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('admin.dashboard');
        }

        $this->userDAO->approve($user);

        return redirect()->route('admin.dashboard');
    }

    public function suspendSubmit(int $userId)
    {
        try {
            $user = $this->userDAO->fetchInfo($userId);
        } catch (ModelNotFoundException $e) {
            Session::flash('message', "Oops! L'utilisateur #{$userId} n'a pu être retrouvé");
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('admin.dashboard');
        }

        $this->userDAO->suspend($user);

        return redirect()->route('admin.dashboard');
    }
}
