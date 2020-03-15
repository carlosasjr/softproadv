<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Repositories\Contracts\StateRepositoryInterface;
use Illuminate\Http\Request;

class StateController extends ControllerStandard
{
    public function __construct(StateRepositoryInterface $state)
    {
        $this->model = $state;
        $this->title = 'Estado';
        $this->view = 'tenants.states';
        $this->route = 'states';

        $this->middleware('can:states');

        $this->middleware('can:create_states')->only(['create', 'store']);
        $this->middleware('can:update_states')->only(['edit', 'update']);
        $this->middleware('can:view_states')->only(['show']);
        $this->middleware('can:delete_states')->only(['delete']);
    }

    public function index()
    {

        if (request()->ajax()) {
            return $this->model
                        ->dataTables('action',  $this->view . '.partials.acoes');


        }

        $title = "Gestão de {$this->title}s";
        return view("{$this->view}.index", compact('title'));
    }

    public function create()
    {
        $countries = $this->model->getCountries();

        $title = "Cadastrar {$this->title}";
        return view("{$this->view}.create", compact('title', 'countries'));
    }

    public function edit($id)
    {
        $data = $this->model->find($id);

        $countries = $this->model->getCountries();

        $title = "Editar {$this->title}: {$data->name}";

        return view("{$this->view}.create", compact('title', 'data', 'countries'));
    }


    public function getCitiesByName($id, Request $request)
    {
        $return = $this->model->getCitiesByName($id, $request);

        if (!$return['status']) {
            return redirect()->back()
                             ->withErrors($return['message']);
        }

        return response()->json($return['data']);
    }
}
