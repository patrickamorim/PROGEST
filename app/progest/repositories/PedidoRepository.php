<?php

namespace App\progest\repositories;

use Auth;
use DB;
use App\Material;
use App\Pedido;
use App\Devolucao;
use App\User;

class PedidoRepository {

    protected $materialRepository;

    public function __construct(MaterialRepository $materialRepository) {
        $this->materialRepository = $materialRepository;
    }

    public function index($input /*= null*/) {
        if ($input) {
            $pedidos = DB::table('pedidos')
            ->join('users', 'users.id', '=', 'pedidos.user_id')
            ->select('users.name as name', 'pedidos.status as status', 'pedidos.id as id','pedidos.created_at as created_at')
            ->where(function($query) use (&$input) {

                       
                        if (isset($input['user_id'])) {
                            $query->where('pedidos.user_id', '=', $input['user_id']);    
                        }
                        if (isset($input['Status']) and (($input['Status'] != "todos") or ($input['Status'] != ""))) {
                       
                            
                            if ($input['Status'] == 'pendente') {
                                $query->where('pedidos.status','=','pendente');
                            } else if ($input['Status'] == 'resolvido') {
                                $query->where('pedidos.status','=','resolvido');
                            }
                        }
                        if(isset($input['busca']) and ($input['busca'] != '')){
                            $query->where("users.name", 'like', "%" . $input['busca'] . "%");
                        }
                  
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate($input['paginate'] == null ? 200 : $input['paginate']); 
        } else { 
            $pedidos = Pedido::all()->sortBy('creatated_at'); 
        } 
        return $pedidos;
    }
   
    public function store($input) {
        $pedido = new Pedido(['obs' => $input['obs'], 'status' => 'Pendente']);
        $pedido->solicitante()->associate(Auth::user());

        $pedido->save();

        foreach ($input['qtds'] as $key => $val) {
            $materiais[$key] = ['quant' => $val];
        }

        $pedido->materiais()->sync($materiais);

        return $pedido;
    }

    public function update($id, $input) {
        $pedido = Pedido::find($id);
        foreach ($input as $key => $val) {
            $pedido->$key = $val;
        }
        return $pedido->save();
    }

    public function show($id) {
        
        return Pedido::findOrFail($id);;
    }

    public function destroy($id) {
        $pedido = Pedido::find($id);
        
        return $pedido->delete();
    }

    public function preparaDadosMateriais($input) {
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
        foreach ($materiaisArray as $key => $val) {
            $materiaisObjects[$key] = new Material([
                'codigo' => $val['codigo'], 'descricao' => $val['descricao'],
                'unidade' => $val['unidade'], 'marca' => $val['marca'],
                'qtd_1' => 0, 'qtd_2' => 0, 'qtd_3' => 0, 'qtd_4' => 0, 'disponivel' => 0
            ]);

            $subItem = SubItem::find($val['sub_item_id']);
            $materiaisObjects[$key]->subItem()->associate($subItem);
            unset($materiaisArray[$key]['codigo']);
            unset($materiaisArray[$key]['descricao']);
            unset($materiaisArray[$key]['unidade']);
            unset($materiaisArray[$key]['marca']);
            unset($materiaisArray[$key]['sub_item_id']);
        }
        $materiais['joinings'] = $materiaisArray;
        $materiais['objects'] = $materiaisObjects;
        return $materiais;
    }
    public function devolucao_user_index($saida = null) {
        if ($saida == null) {
            return Devolucao::orderBy('created_at', 'desc')
            ->join("saidas","saidas.id","=","devolucaos.saida_id")
            ->join("users","users.id","=","saidas.solicitante_id")
            ->select("devolucaos.id as id","devolucaos.saida_id","devolucaos.created_at","devolucaos.updated_at")
            ->where("users.name","=", Auth::user()->name)->paginate(50);
           
           // return Devolucao::orderBy('created_at', 'desc')->paginate(50);
        } 
    
    }

    public function devolucao_show($id) {
        return Devolucao::findOrFail($id);
    }

}
