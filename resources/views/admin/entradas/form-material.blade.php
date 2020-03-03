<fieldset>
    <legend>Novo material</legend>
        <div class="row">
            <div class='form-group'> 
                <div class='col-md-3'>
                    {!!Form::label('codigo[]', 'Código', array('class'=>'control-label'))!!}
                    {!!Form::text('codigo[]', null, array('class'=>'form-control', 'id' => 'codigo[]', 'required' => 'required'))!!}
                </div>

                <div class='col-md-9'>
                    {!!Form::label('descricao[]', 'Descrição', array('class'=>'control-label'))!!}
                    {!!Form::text('descricao[]', null, array('class'=>'form-control', 'id' => 'descricao[]', 'required' => 'required'))!!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class='form-group'>
                <div class='col-md-2'>
                    {!!Form::label('unidade[]', 'Unidade', array('class'=>'control-label'))!!}
                    {!!Form::text('unidade[]', null, array('class'=>'form-control', 'id' => 'unidade[]', 'required' => 'required'))!!}
                </div>
                <div class='col-md-5'>
                    {!!Form::label('marca[]', 'Marca', array('class'=>'control-label'))!!}
                    {!!Form::text('marca[]', null, array('class'=>'form-control', 'id' => 'marca[]', 'required' => 'required'))!!}
                </div>
                <div class='col-md-5'>
                    {!!Form::label('sub_item_id[]', 'Subitens', array('class'=>'control-label'))!!}
                    {!!Form::select('sub_item_id[]', $subitens, null, ['required' => 'required', 'class'=>'form-control', 'id'=>'sub_item_id[]'])!!}
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class='form-group'>
                <div class='col-md-3'>
                    {!!Form::label('vl_total[]', 'Valor total', array('class'=>'control-label'))!!}
                    {!!Form::text('vl_total[]', null, array('class'=>'form-control', 'id' => 'vl_total[]', 'required' => 'required'))!!}
                </div>
                <div class='col-md-3'>
                    {!!Form::label('quant[]', 'Quantidade', array('class'=>'control-label'))!!}
                    {!!Form::text('quant[]', null, array('class'=>'form-control', 'id' => 'quant[]', 'required' => 'required'))!!}
                </div>
            </div>
        </div>

</fieldset>
