<div class="row">
            <fieldset>
                <legend>Filtros</legend>
                {!! Form::open(array('route' => 'admin.pedidos.index', 'method'=>'GET', 'class'=>'')) !!}
                <div class='col-md-10 '>
                    <div class="form-inline input-group ">


                        <div class='col-md-3'>
                            {!!Form::label('busca', 'Busca', array('class'=>'control-label'))!!}
                            {!!Form::text('busca', old('busca'), array('class'=>'form-control', 'id' => 'busca', 'placeholder'=>'solicitante'))!!}
                        </div>

                        <div class='col-md-2'>
                            {!!Form::label('Status', 'Status', array('class'=>'control-label'))!!}
                            {!!Form::select('Status', $filter['status'], old('status'), ['class'=>'form-control', 'id'=>'status'])!!}
                        </div>

                        <div class='col-md-2'>
                            {!!Form::label('paginate', 'Mostrar', array('class'=>'control-label'))!!}
                            {!!Form::select('paginate', $filter['paginate'], old('paginate'), ['class'=>'form-control', 'id'=>'paginate'])!!}
                        </div>
                        <div class='col-md-1'>
                            <label class="control-label"></label>
                            <span class="input-group">
                                    {!! Form::submit('Filtrar', ['class'=>'btn btn-default'])!!}
                                </span>
                        </div>
                    </div>
                </div>
                <div class='col-md-4'>

                </div>
                <!--                <div class='col-md-2'><br>
                
                                </div>-->
                {!! Form::close() !!}
            </fieldset>
        </div>