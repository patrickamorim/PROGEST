@extends('admin.admin_template')

@section('content')
<!--Content Wrapper. Contains page content -->
<div id="a" class = "content-wrapper">
    <!--Content Header (Page header) -->
    <section class = "content-header">
        <h1>
            {!! $page_title or "SubItens e Materiais" !!}
            <small>{!! $page_description or null !!}</small>
        </h1>
        @include('template.alerts')
        <!-- Busca e filtros -->
        <br>
        <fieldset>
            <div class="row">

                {!! Form::open(array('route' => 'admin.relatorios.saidasPorMateriais', 'method'=>'GET', 'class'=>'')) !!}
               
                
                <div class='col-md-4'>
                    {!!Form::label('busca', 'Busca', array('class'=>'control-label'))!!}
                    {!!Form::text('busca', old('busca'), array('class'=>'form-control', 'id' => 'busca', 'placeholder'=>'Material ou Categoria'))!!}
                </div>
     
                <div class='col-md-2'>
                    {!!Form::label('dt_inicial', 'Data Inicial', array('class'=>'control-label'))!!}
                    {!!Form::date('dt_inicial', old('dt_inicial'), ['class'=>'form-control', 'id'=>'dt_inicial', 'required'=>'required'])!!}
                </div>
                <div class='col-md-2'>
                    {!!Form::label('dt_final', 'Data Final', array('class'=>'control-label'))!!}
                    {!!Form::date('dt_final', old('dt_final'), ['class'=>'form-control', 'id'=>'dt_final', 'required'=>'required'])!!}
                </div>
                <div class='col-md-1'>
                    <div class="input-group">
                        {!!Form::label('', '', array('class'=>'control-label'))!!}
                        <span class="input-group">
                            {!! Form::submit('Ir', ['class'=>'btn btn-default'])!!}
                        </span>
                    </div>
                   
                </div>
                {!! Form::close() !!}
            </div>
        </fieldset>
        <br>
    </section>

    <!--Main content -->
    <section class = "content">
        <!--Your Page Content Here -->
        @yield('relatorio')
    </section><!--/.content -->
</div><!--/.content-wrapper -->
@stop

