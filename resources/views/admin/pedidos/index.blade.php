@extends('admin.admin_template')

@section('content')
<!-- Laravel DELETE plugin -->
<script>
    window.csrfToken = '<?php echo csrf_token(); ?>';
</script>
<!--Content Wrapper. Contains page content -->
<div class = "content-wrapper">
    <!--Content Header (Page header) -->
    <section class = "content-header">
        <h1>
            {!! $page_title or "Pedidos" !!}
        </h1>
        @include('template.alerts')
        <br>
        @include('admin.pedidos.formFilter')
    </section>
    
   

    <!--Main content -->
    <section class = "content">
        <!--Your Page Content Here -->
        @if(count($pedidos) > 0)
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Solicitante</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                <tr class="{!!$pedido->status == 'Pendente'? 'warning' : ''!!}">
                    <td>{!! $pedido->id !!}</td>
                    <td>{!! $pedido->name !!}</td>
                    <td>{!! ($pedido->status == 'Pendente') ? '<b>Pendente</b>' : 'Resolvido' !!}</td>
                    <td>{!! date('d/m/Y',strtotime($pedido->created_at)) !!}</td>
                    <td width="1%" nowrap>
                        <a href="{!! route('admin.pedidos.show', $pedido->id) !!}" class="btn btn-info btn-xs">
                            <i class="fa fa-fw fa-eye"></i> visualizar
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-12 text-center">
                {!! str_replace('/?', '?', $pedidos->appends($search)->render()) !!}
            </div>
        </div>
        @else
        <h5 class="well">Nenhum pedido ainda cadastrado.</h5>
        @endif
    </section><!--/.content -->
</div><!--/.content-wrapper -->
@stop

