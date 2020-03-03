@extends('admin.admin_template')

@section('content')

<!--Content Wrapper. Contains page content -->
<div class = "content-wrapper">
    <!--Content Header (Page header) -->
    <section class = "content-header">
        <h1>
            {!! $page_title or "Nova entrada" !!}
            <small>{!! $page_description or null !!}</small>
        </h1>
    </section>

    <!--Main content -->
    <section class = "content">
        {!! Form::model($entrada, ['route' => ["admin.empenhos.entradas.store", $empenho->id] ])!!}
        @include('admin.entradas.form')
        <div class="form-group">
            <div class='col-md-12'>
                {!!Form::submit('Salvar', ['class'=>'btn btn-primary pull-right'])!!}
            </div>
        </div>
        {!! Form::close()!!}

    </section><!--/.content -->
</div><!--/.content-wrapper -->
@stop

