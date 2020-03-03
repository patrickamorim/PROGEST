<?php

namespace App\progest\repositories;

use App\Coordenacao;
use App\Setor;

class SetorRepository {

    public function dataForSelect() {
        $baseArray = Setor::all();
        $setores = array();
        $setores[''] = 'Selecione...';
        foreach ($baseArray as $value) {
            if ($value->status == 1){
                $setores[$value->id] = $value->name;
            }
        }
        return $setores;
    }

    public function index($filter = null) {
        if ($filter) {
            $setores = Setor::where(function($query) use (&$filter) {
                        if (isset($filter['habilitado'])) {
                            $query->where('status', '=', $filter['habilitado']);
                        }
                        if (isset($filter['busca']) && $filter['busca'] != '') {
                            $query->where('name', 'like', "%" . $filter['busca'] . "%");
                        }
                    })->paginate($filter['paginate']);
        } else {
            $setores = Setor::paginate(50);
        }
        return $setores;
    }

    public function store($input) {
        $setor = new Setor();
        $setor->name = $input['name'];
        
        $coordenacao = Coordenacao::find($input['coordenacao_id']);
        $setor->coordenacao()->associate($coordenacao);
        
        $setor->status = isset($input['status']) ? 1 : 0;
        //$setor->status = 1;
        $setor->save();
    }

    public function update($id, $input) {
        $setor = Setor::find($id);
        $setor->name = $input['name'];
        
        $coordenacao = Coordenacao::find($input['coordenacao_id']);
        $setor->coordenacao()->associate($coordenacao);

        $setor->status = isset($input['status']) ? 1 : 0;

        return $setor->save();
    }

    public function show($id) {
        return Setor::findOrFail($id);
    }

    public function destroy($id) {
        $setor = Setor::find($id);
        return $setor->delete();
    }
    
//    public function desativar($id){
//        $setor = Setor::find($id);
//        $setor->status = 0;
//        return $setor->save();
//    }

}
