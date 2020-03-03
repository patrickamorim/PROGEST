
@extends('admin.relatorios.totalSaidas.index')
@section('relatorio')

@if(count($saidas) > 0)

<h4 class="text-right">Consumo por total - Período: {!!$periodo['dt_inicial']!!} a {!!$periodo['dt_final']!!}</h4>

<div id="divpdf"  class="panel">
    
    <table title="Para imprimir ou salvar em PDF(Google Chrome), use Ctrl + P" class="table table-bordered table-hover table-stripedf">
        <thead>
        <tr class="">
            <th>Descrição do item</th>
            <th>Categoria</th>
            <th>Data</th>
            <th>Quantidade</th>
            <th>Vl. unitário</th>
            <th>Vl. total</th>
        </tr>
@foreach($saidas as $key=>$saida)
        <tr><tr><th colspan = "6" class="text-left bg-gray"> {!!$saida["$criterioAtual"]!!}</th></tr></tr>
        </thead>
        <tbody>
            @foreach ($saida['subMateriais'] as $subMateriais)
            @foreach ($subMateriais as $subMaterial)
            <tr class="">
                <td>{!! $subMaterial->material->descricao !!}</td>
                <td>{!! $subMaterial->subItem->material_consumo !!} - {!! $subMaterial->subItem->id !!}</td>
                <td>{!! date('d/m/Y',strtotime($subMaterial->pivot->created_at)) !!}</td>
                <td>{!! $subMaterial->pivot->quant !!}</td>
                <td>{!! $subMaterial->present()->getValorUn() !!}</td>
                <td class="text-right">{!! $subMaterial->present()->formatReal($subMaterial->pivot->quant * $subMaterial->present()->getValorUnBruto) !!}</td>
            </tr>
            @endforeach   
            @endforeach 
            <tr class="panel-footer">
               <td colspan="6" class="text-right"><span>SubTotal:   </span> <b>{!!$saida['total']!!}</b></td>
            </tr>
@endforeach
        </tbody>
    </table>
</div>
<br>

<div class="row">
    <div class="col-md-6 pull-right">
        <p class="text-right">Total no período: <b>{!!$total!!}</b></p>
    </div>
</div>
@endif
@stop