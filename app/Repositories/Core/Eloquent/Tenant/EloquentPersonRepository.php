<?php

namespace App\Repositories\Core\Eloquent\Tenant;

use App\Models\Person;
use App\Repositories\Contracts\PersonRepositoryInterface;
use App\Repositories\Core\BaseEloquentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


/**
 * .class [ TIPO ]
 *
 * @copyright (c) 2018, Carlos Junior
 */
class EloquentPersonRepository extends BaseEloquentRepository
    implements PersonRepositoryInterface
{
    /*     * ************************************************ */
    /*     * ************* METODOS PRIVADOS ***************** */
    /*     * ************************************************ */

    /**
     * @param array $data
     * @param $person
     * @return bool
     */
    private function saveAddress(array $data, $person)
    {
        if (isset($data['address'])) {
            foreach ($data['address'] as $item) {

                $id = ($item['id'] > 0) ? $item['id'] : 0;

                $insert = $person->addresses()->updateOrCreate(['id' => $id], $item);

                if (!$insert) {
                    return false;
                }
            }

            return true;
        }

        return true;
    }


    /**
     * @param array $data
     * @param $person
     * @return bool
     */
    private function saveContacts(array $data, $person)
    {
        if (isset($data['contacts'])) {
            foreach ($data['contacts'] as $item) {

                $id = ($item['id'] > 0) ? $item['id'] : 0;

                $insert = $person->contacts()->updateOrCreate(['id' => $id], $item);

                if (!$insert) {
                    return false;
                }
            }

            return true;
        }

        return true;
    }


    /*     * ************************************************ */
    /*     * ************* METODOS PUBLICOS ***************** */
    /*     * ************************************************ */
    public function model()
    {
        return Person::class;
    }


    public function create(array $data)
    {
        DB::beginTransaction();

        try {

            $data['state'] = (isset($data['state']) ? 'I' : 'A');
            $data['user_id'] = Auth::user()->id;

            $person = parent::create($data);

            $addresses = $this->saveAddress($data, $person);
            $contacts = $this->saveContacts($data, $person);


            if (!$person || !$addresses || !$contacts) {
                DB::rollBack();

                return [
                    'status' => false,
                    'message' => 'Não foi possível salvar o registro'
                ];

            }

            DB::commit();

            return ['status' => true];

        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => false,
                'message' => 'Não foi possível salvar o registro.' . $e->getMessage()
            ];
        }
    }


    public function update($id, array $data)
    {
        if (!$person = parent::find($id)) {
            return [
                'status' => false,
                'message' => 'Registro não encontrado!'
            ];
        }

        DB::beginTransaction();
        try {
            $person->update($data);

            $addresses = $this->saveAddress($data, $person);
            $contacts = $this->saveContacts($data, $person);

            if (!$person || !$addresses || !$contacts) {
                DB::rollBack();

                return [
                    'status' => false,
                    'message' => 'Não foi possível atualizar o registro'
                ];
            }


            DB::commit();

            return ['status' => true];

        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => false,
                'message' => 'Não foi possível atualizar o registro.' . $e->getMessage()
            ];
        }

    }


    public function getPersonProcesses(Request $request)
    {
        $data = [];

        if ($request->has('q') && !empty($request->q)) {

            $search = $request->q;

            $data = $this->relationships('processes')
                ->orWhere('name', 'LIKE', "%$search%")
                ->orWhere('cpf', 'LIKE', "%$search%")
                ->get();

            $processes = $this->getProcesses($data);

            return [
                'status' => true,
                'data' => $processes,
            ];
        }
    }

    /**
     * @param $data
     * @return array
     */
    private function getProcesses($data): array
    {
        $processes = [];

        foreach ($data as $person) {
            foreach ($person->processes as $process) {
                $processes[] = [
                    'id' => $process->id,
                    'process' => $process->number_process . ' - ' . $person->name,
                    ];
            }
        }

        return $processes;
    }

}
