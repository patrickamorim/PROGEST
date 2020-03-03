<?php

namespace App\Http\Controllers;

use URL;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CriarFornecedorRequest;
use Illuminate\Http\Request;
use App\progest\repositories\FornecedorRepository;

class FornecedorController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $fornecedorRepository;

    public function __construct(FornecedorRepository $userRepository) {
        $this->fornecedorRepository = $userRepository;
    }

    public function index(Request $input) {
        $input->flash();
        $input = $input->all();
        $filter = $input;
        $filter['paginate'] = 50;
        
        $fornecedores = $this->fornecedorRepository->index($filter);
        return view('admin.fornecedores.index')->with(compact('fornecedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $fornecedor = null;
        return view('admin.fornecedores.create')->with(compact('fornecedor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CriarFornecedorRequest $request) {
        $this->fornecedorRepository->store($request->all());
        return redirect()->route('admin.fornecedores.index')->with('success', 'Registro inserido com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if (URL::current() != URL::previous()){
            Session::forget('_old_input');
        }
        $fornecedor = $this->fornecedorRepository->show($id);
        return view('admin.fornecedores.edit')->with(compact('fornecedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->fornecedorRepository->update($id, $request->all());
        return redirect()->route('admin.fornecedores.index')->with('success', 'Registro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $this->fornecedorRepository->destroy($id);
        return back()->with('success', 'Removido com sucesso!');
    }

//    public function desativar($id) {
//        $this->fornecedorRepository->desativar($id);
//        return back()->with('success', 'Desativado com sucesso!');
//    }
}
