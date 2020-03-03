
@extends('admin.relatorios.saidasPorProdutos.index')
@section('relatorio')

@if(count($saidas) > 0)

<h4 class="text-right"> Consumo por Material - Período: {!!$periodo['dt_inicial']!!} a {!!$periodo['dt_final']!!} </h4>

<div id="divpdf" class="panel">
    
    <table class="table table-bordered table-hover table-striped text-left ">
        <thead class="">
        
@foreach($saidas as $key => $saidai)
    <tr class="">
        <th colspan = "5" class="text-left bg-gray"> {{$key}} - {{$saidai[0]->material_consumo}} ({{$saidai[0]->sub_item_id}}) </th></tr></tr>
    </tr>
    <tr class="">
        <th>Solicitante</th>
        <th>Data</th>
        <th class="text-right">Quantidade</th>
    </tr>
        
        </thead>
        <tbody>
            @foreach($saidai as $kay => $saida)
                <tr class="panel-footer">
                    <td  class="text-left">{{ $saida->name }}</td>
                    <td  class="text-left">{{ date('d/m/Y',strtotime($saida->created_at)) }}</td>
                    <td  class="text-right">{{ $saida->quant }}</td>
                </tr>
            @endforeach      
            
@endforeach
        </tbody>
    </table>
</div>
<br>


@endif
@stop