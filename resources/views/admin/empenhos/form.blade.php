@if ($errors->any())
<div class="container-fluid">
    <ul class="alert alert-error">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<script></script>
<div class="container-fluid">
    <div class="row">
        <div class='form-group'> 
            <div class='col-md-6'>
                {!!Form::label('numero', 'Número', array('class'=>'control-label'))!!}
                {!!Form::text('numero', null, array('class'=>'form-control', 'id' => 'numero', 'required' => 'required'))!!}
            </div>

            <div class='col-md-6'>
                {!!Form::label('tipo', 'Tipo', array('class'=>'control-label'))!!}
                {!!Form::select('tipo', ['ORDINÁRIO'=>'ORDINÁRIO', 'ESTIMATIVO' => 'ESTIMATIVO', 'GLOBAL' => 'GLOBAL'], null, ['required' => 'required', 'class'=>'form-control', 'id'=>'fornecedor_id'])!!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class='form-group'>
            <div class='col-md-6'>
                {!!Form::label('fornecedor_id', 'Fornecedor', array('class'=>'control-label'))!!}
                {!!Form::select('fornecedor_id', $fornecedores, null, ['required' => 'required', 'class'=>'form-control', 'id'=>'fornecedor_id'])!!}
            </div>
            <div class='col-md-2'>
                {!!Form::label('cat_despesa', 'Categoria da despesa', array('class'=>'control-label'))!!}
                {!!Form::text('cat_despesa', null, array('class'=>'form-control', 'id' => 'cat_despesa', 'required' => 'required'))!!}
            </div>
            @include('admin.empenhos.lista_elemento_consumo')
        </div>
    </div>

    <div class="row">
        <div class='form-group'>
            <div class='col-md-6'>
                {!!Form::label('mod_licitacao', 'Modalidade da licitação', array('class'=>'control-label'))!!}
<!--                {!!Form::text('mod_licitacao', null, array('class'=>'form-control', 'id' => 'mod_licitacao', 'required' => 'required'))!!}-->
                {!!Form::select('mod_licitacao', [
                ''=>'Selecione...', 
                'Concorrência'=>'Concorrência', 
                'Concurso'=>'Concurso', 
                'Convite'=>'Convite', 
                'Leilão'=>'Leilão', 
                'Pregão'=>'Pregão', 
                'Pregão Eletrônico'=>'Pregão Eletrônico', 
                'Tomada de Preços' => 'Tomada de Preços'
                ], null, ['required' => 'required', 'class'=>'form-control', 'id'=>'mod_licitacao'])!!}
            </div>
            <div class='col-md-6'>
                {!!Form::label('num_processo', 'Nº do processo', array('class'=>'control-label'))!!}
                {!!Form::text('num_processo', null, array('class'=>'form-control', 'id' => 'num_processo', 'required' => 'required'))!!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class='form-group'>
            <div class='col-md-12'>
                {!!Form::label('solicitante_id', 'Solicitante', array('class'=>'control-label'))!!}
                {!!Form::select('solicitante_id', $users, null, ['required' => 'required', 'class'=>'form-control', 'id'=>'solicitante_id'])!!}
            </div>
        </div>
    </div>
    <br>
    @include('admin.empenhos.form-select-material')
    <br>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Materiais</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descricao</th>
                                <th>Quantidade</th>
                                <th>Valor total</th>
                                <th>Valor unitário</th>
                                <th>Vencimento</th>
                                <th>SubItem</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody id='lista-materiais'>
                            @yield('lista-materiais')
                        </tbody>
<!--                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">Total</td>
                                <th id="valor-total-empenho" >00,00</td>
                            </tr>
                        </tfoot>-->
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>
    </div>
    <br>
    <div class='new-material'>

    </div>
    <br>
    
    <div class="row">
        <div class='col-md-3 col-md-offset-9 text-right'>
            <b>Total: <span id='valor-total-empenho'>00,00</span></b>
        </div>
    </div>
</div>

