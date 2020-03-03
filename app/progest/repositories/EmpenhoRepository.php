<?php

namespace App\progest\repositories;

use App\Fornecedor;
use App\User;
use App\Empenho;
use App\Material;
use App\SubMaterial;
use App\SubItem;
use App\Entrada;
use App\Unidade;
use App\progest\repositories\ImagemRepository;

class EmpenhoRepository {

    protected $materialRepository;
    protected $imagemRepository;

    public function __construct(MaterialRepository $materialRepository, ImagemRepository $imagemRepository) {
        $this->materialRepository = $materialRepository;
        $this->imagemRepository = $imagemRepository;
    }

    public function index($input = null) {
        if ($input) {
            $empenhos = Empenho::where(function($query) use (&$input) {
                        if (isset($input['dt_inicial']) && isset($input['dt_final']) && $input['dt_inicial'] != null && $input['dt_final'] != null) {
                            $query->whereBetween('created_at', [[$input['dt_inicial']." 00:00:00", $input['dt_final']." 23:59:59"]]);
                        }
                        if (isset($input['busca']) && $input['busca'] != '') {
                            $query->where('numero', 'like', "%" . $input['busca'] . "%")
                                    ->orWhere('mod_licitacao', 'like', "%" . $input['busca'] . "%")
                                    ->orWhere('num_processo', 'like', "%" . $input['busca'] . "%");
                        }

                        $query->whereHas('solicitante', function ($query) use (&$input) {
                            if (isset($input['solicitante_id']) && $input['solicitante_id'] != null) {
                                $query->where('id', $input['solicitante_id']);
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
                        if (isset($input['fornecedor_id']) && $input['fornecedor_id'] != '') {
                            $query->whereHas('fornecedor', function($query) use (&$input) {
                                $query->where('id', $input['fornecedor_id']);
                            });
                        }
                        if (isset($input['status']) && $input['status'] != '') {
                            if ($input['status'] == 'pendente') {
                                $query->whereHas('subMateriais', function ($query) use (&$input) {
                                    $query->whereHas('entradas', function ($query) use (&$input) {
                                        $query->havingRaw('SUM(entrada_sub_material.quant) != sub_materials.qtd_solicitada');
                                    });
                                });
                                $query->orWhere(function($query) {
                                    $query->whereDoesntHave('entradas');
                                });
                            } else if ($input['status'] == 'fechado') {
                                $query->whereHas('entradas.subMateriais', function ($query) {
                                    $query->havingRaw('SUM(entrada_sub_material.quant) = SUM(qtd_solicitada)');
                                });
                            }
                        }
                    })->with(['solicitante', 'fornecedor', 'subMateriais.entradas'])->orderBy('created_at', 'desc')->paginate($input['paginate'] == null ? 1000 : $input['paginate']);
        } else {
            $empenhos = Empenho::all()->sortByDesc('created_at');
        }  
        return $empenhos;
    }
    
    public function showByNr($numero){
        return Empenho::where('numero', $numero)->get();
    }

    public function store($input) {
        $fornecedor_id = $input['empenho']['fornecedor_id'];
        $solicitante_id = $input['empenho']['solicitante_id'];
        unset($input['empenho']['fornecedor_id']);
        unset($input['empenho']['solicitante_id']);
        $empenho = new Empenho($input['empenho']);

        $fornecedor = Fornecedor::find($fornecedor_id);
        $solicitante = User::find($solicitante_id);
        $empenho->fornecedor()->associate($fornecedor);
        $empenho->solicitante()->associate($solicitante);
        $empenho->save();

        $subMateriais = $this->prepararSubMateriais($input['materiais'], $empenho);
        if ($subMateriais) {
            $empenho->subMateriais()->saveMany($subMateriais);
        }
        if ($input['submateriais']['submateriais']) {
            foreach ($input['submateriais']['submateriais'] as $id => $array) {
                $subMaterial = new SubMaterial([
                    'vencimento' => $array['vencimento'],
                    'vl_total' => $this->realToDolar($array['vl_total']),
                    'qtd_solicitada' => $array['qtd_solicitada'],
                    'material_id' => $id,
                ]);
                $subItem = SubItem::find($array['subItem']);
                $subMaterial->subItem()->associate($subItem);
                $subMaterial->empenho()->associate($empenho);
                $subMaterial->save();
            }
        }
//
    }

    public function update($id, $input) {
        $empenho = Empenho::find($id);
        $empenho->numero = $input['empenho']['numero'];
        $empenho->tipo = $input['empenho']['tipo'];
        $empenho->cat_despesa = $input['empenho']['cat_despesa'];
        $empenho->el_consumo = $input['empenho']['el_consumo'];
        $empenho->mod_licitacao = $input['empenho']['mod_licitacao'];
        $empenho->num_processo = $input['empenho']['num_processo'];

        $fornecedor = Fornecedor::find($input['empenho']['fornecedor_id']);
        $solicitante = User::find($input['empenho']['solicitante_id']);
        $empenho->fornecedor()->associate($fornecedor);
        $empenho->solicitante()->associate($solicitante);

        if ($input['submateriais']['submateriais']) {
            foreach ($empenho->subMateriais as $subMaterial) {
                $subMaterial->delete();
            }
            foreach ($input['submateriais']['submateriais'] as $id => $array) {
                $subMaterial = new SubMaterial([
                    'vencimento' => $array['vencimento'],
                    'vl_total' => $this->realToDolar($array['vl_total']),
                    'qtd_solicitada' => $array['qtd_solicitada'],
                    'material_id' => $id,
                ]);
                $subItem = SubItem::find($array['subItem']);
                $subMaterial->subItem()->associate($subItem);
                $subMaterial->empenho()->associate($empenho);
                $subMaterial->save();
            }
        }

        $subMateriais = $this->prepararSubMateriais($input['materiais'], $empenho);
        if ($subMateriais) {
            $empenho->subMateriais()->saveMany($subMateriais);
        }

        return $empenho->save();
    }

    public function show($id) {
        return Empenho::find($id);
    }

    public function destroy($id) {
        $empenho = Empenho::find($id);
        foreach ($empenho->subMateriais as $subMaterial) {
            $subMaterial->delete();
        }
        return $empenho->delete();
    }

    public function realToDolar($input) {

        if (is_array($input)) {
            foreach ($input as $key => $val) {
                $input[$key] = str_replace(',', '.', str_replace('.', '', $val));
            }
        } else {
            $input = str_replace(',', '.', str_replace('.', '', $input));
        }

        return $input;
    }

    public function prepararSubMateriais($input, $empenho) {
        $materiaisArray = array();
        foreach ($input as $key => $val) {
            if ($val === null) {
                return false;
            }
            foreach ($val as $i => $j) {
                $materiaisArray[$i][$key] = $j;
            }
        }
        $materiaisObjects = array();
        $subMateriaisObjects = array();
        foreach ($materiaisArray as $key => $val) {
            $materiaisObjects[$key] = new Material([
                'codigo' => $val['codigo'], 'descricao' => $val['descricao'],
                'marca' => $val['marca'],
                'qtd_min' => $val['qtd_min'], 'imagem' => '',
                'disponivel' => 1
            ]);

            if (isset($val['imagem'])) {
                $thumbs = [
                    ['width' => '400', 'height' => '400'],
                    ['width' => '100', 'height' => '100'],
                ];
                $materiaisObjects[$key]->imagem = $this->imagemRepository->sendImage($val['imagem'], 'img/materiais/', $thumbs);
            }

            $unidade = Unidade::find($val['unidade_id']);
            $materiaisObjects[$key]->unidade()->associate($unidade);
            $materiaisObjects[$key]->save();

            $subMateriaisObjects[$key] = new SubMaterial([
                'vencimento' => isset($val['vencimento']) ? $val['vencimento'] : null,
                'qtd_estoque' => 0, 'qtd_solicitada' => $val['qtd_solicitada'],
                'vl_total' => $this->realToDolar($val['vl_total']),
            ]);

            $subItem = SubItem::find($val['sub_item_id']);
            $subMateriaisObjects[$key]->subItem()->associate($subItem);
            $subMateriaisObjects[$key]->material()->associate($materiaisObjects[$key]);
            $subMateriaisObjects[$key]->empenho()->associate($empenho);
        }
        return $subMateriaisObjects;
    }

    public function getQtdsEntregues($empenho) {
        foreach ($empenho->subMateriais as $subMaterial) {
            $qtds[$subMaterial->id]['qnt_entregue'] = 0;
        }
        foreach ($empenho->entradas as $entrada) {
            foreach ($entrada->materiais as $subMaterial) {
                $qtds[$subMaterial->id]['qnt_entregue'] += $subMaterial->pivot->quant;
            }
        }

        return $qtds;
    }

}
