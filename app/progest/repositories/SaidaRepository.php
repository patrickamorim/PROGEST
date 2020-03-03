<?php

namespace App\progest\repositories;

use Auth;
use App\Saida;
use App\Material;
use App\SubMaterial;
use App\User;
use App\Pedido;
use DB;

class SaidaRepository {

    protected $relatorioRepository;

    public function __construct(RelatorioRepository $relatorioRepository) {
        $this->relatorioRepository = $relatorioRepository;
    }

    public function index($input = null) {
        if ($input == null) {
            return Saida::orderBy('created_at', 'desc')->paginate(50);
        } else {
            $saidas = Saida::where(function($query) use (&$input) {
                        if (isset($input['dt_inicial']) && isset($input['dt_final']) && $input['dt_inicial'] != null && $input['dt_final'] != null) {
                            $query->whereBetween('created_at', [[$input['dt_inicial']." 00:00:00", $input['dt_final']." 23:59:59"]]);
                        }
                        $query->whereHas('solicitante', function ($query) use (&$input) {
                            if (isset($input['solicitante_id']) && $input['solicitante_id'] != null) {
                                $query->where('id', $input['solicitante_id']);
                            }else{
                                $query->where('id','>',0);
                            }
                            if (isset($input['setor_id']) && $input['setor_id'] != null) {
                                $query->whereHas('setor', function($query) use (&$input) {
                                    $query->where('id', $input['setor_id']);
                                });
                            }
                            if (isset($input['coordenacao_id']) && $input['coordenacao_id'] != null) {
                                $query->whereHas('setor', function($query) use (&$input) {
                                    $query->whereHas('coordenacao', function($query) use (&$input) {
                                        $query->where('id', $input['coordenacao_id']);
                                    });
                                });
                            }
                        });
                    })->with(['subMateriais.material','subMateriais.subItem', 'subMateriais.empenho', 'solicitante.setor.coordenacao'])->orderBy('created_at', 'desc')->paginate($input['paginate'] == null ? 1000 : $input['paginate']);
            return $saidas;
        }
    }

    public function indexSaidas($input = null) {
        
        $saidas = collect(DB::table('materials')->select('materials.descricao','sub_materials.sub_item_id','sub_items.material_consumo','materials.id', 'users.name', 'saida_sub_material.quant','saida_sub_material.created_at')
        ->JOIN('sub_materials','sub_materials.material_id',"=","materials.id" )
        ->JOIN('sub_items','sub_items.id','=','sub_materials.sub_item_id')
        ->join("saida_sub_material","sub_materials.id","=","saida_sub_material.sub_material_id")
        ->join("saidas","saidas.id","=","saida_sub_material.saida_id")
        ->join("users","saidas.solicitante_id","=","users.id")
        ->whereBetween('saidas.created_at', [[$input['dt_inicial']." 00:00:00", $input['dt_final']." 23:59:59"]])
        ->whereRaw("(materials.descricao LIKE  '%" . $input['busca'] . "%' or sub_items.material_consumo LIKE '%" . $input['busca'] . "%')")
        ->orderBy('saida_sub_material.created_at','desc')
        ->get());
        
        return $saidas->groupBy('descricao');
        
    }

    public function store($input) {
        $subMateriais = $this->saidaSubMateriais($input['materiais']['qtds']);
        $saida = new Saida(['obs' => $input['saida']['obs']]);
        if (!isset($input['pedido_id'])) {
            $usuario = User::where('email', $input['saida']['email'])->get()->first();
        } else {
            $usuario = User::find(Pedido::where('id', $input['pedido_id'])->get()->first()->solicitante->id);
            $pedido = Pedido::find($input['pedido_id']);
            $saida->pedido()->associate($pedido);
        }
        $saida->solicitante()->associate($usuario);
        $saida->responsavel()->associate(Auth::user());
        $saida->save();

        $saida->subMateriais()->sync($subMateriais);

        return $saida;
    }

    public function update($id, $input) {
        
    }

    public function show($id) {
        return Saida::find($id);
    }

    public function destroy($id) {
        $saida = Saida::find($id);

        foreach ($saida->subMateriais as $subMaterial) {
            $valor = round(($subMaterial->vl_total / $subMaterial->qtd_solicitada) * $subMaterial->pivot->quant, 2);
            $this->relatorioRepository->updateSaldo($subMaterial, $valor);
            $subMaterial->qtd_estoque += $subMaterial->pivot->quant;
            $subMaterial->save();
        }
        return $saida->delete();
    }

    public function saidaSubMateriais($materiaisInput) {
        $subMateriaisArray = [];
        foreach ($materiaisInput as $id => $qtd) {
            $material = Material::find($id);
            $subMateriais = $material->subMateriais->filter(function($item) {
                        return $item->qtd_estoque > 0;
                    })->sortBy('created_at');
            $rest = $qtd;
            foreach ($subMateriais as $subMaterial) {
                $valor = "-" . round(($subMaterial->vl_total / $subMaterial->qtd_solicitada) * $rest, 2);
                $this->relatorioRepository->updateSaldo($subMaterial, $valor);
                if ($subMaterial->qtd_estoque >= $rest) {
                    $subMaterial->qtd_estoque -= $rest;
                    $subMateriaisArray[$subMaterial->id] = ['quant' => $rest];
                    $rest = 0;
                } else {
                    $rest -= $subMaterial->qtd_estoque;
                    $subMateriaisArray[$subMaterial->id] = ['quant' => $subMaterial->qtd_estoque];
                    $subMaterial->qtd_estoque -= $subMaterial->qtd_estoque;
                }
                $subMaterial->save();
                if ($rest == 0)
                    break;
            }
        }
        return $subMateriaisArray;
    }

}
