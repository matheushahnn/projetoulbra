<div class="wrapper wrapper-content animated fadeInRight">
  <div class='row'>
    <div class="col-md-12">
      <div class='ibox float-e-margins'>
        <div class='ibox-content'>
          @if ( isset( $procedimento ) )
          	<form method='post' action="{{ route('agenda_dia.update', $agendaDia->id) }}" class='form-horizontal'>

          	{!! method_field('PUT') !!}

          @else

          	<form method='post' action="{{ route('agenda_dia.store') }}" class='form-horizontal'>
          	
          @endif
          	
          @if( isset($errors) && count( $errors ) > 0 )
          	<div class='alert alert-danger'>
          		@foreach( $errors->all() as $erro )

          			<p>{{ $erro }}</p>

          		@endforeach
          	</div>
          @endif

          	{!! csrf_field() !!}

            <input type='hidden' value='{{ $profissional->id_agenda_profissional }}' name='id_agenda_profissional'/>
            <input type='hidden' value='{{ $agendaDia['hora_selecionada'] }}' name='hora'/>
            <input type='hidden' value='{{ $agendaDia['dia_selecionado'] }}' name='data'/>

              <div class="form-group col-sm-12">
                <p> <b>Profissional: </b> {{ $profissional->nome or old( 'nome_profissional' ) }}</p>
              </div>
              <div class="form-group">
                <div class='col-sm-6 '>
                  <p> <b>Hora: </b> {{ $agendaDia['hora_selecionada'] }}</p>
                </div>    
                <div class='col-sm-6'>
                  <p> <b>Data: </b> {{ $agendaDia['dia_selecionado'] }}</p>
                </div>    
              </div>    
          	<div class="form-group">
              <label for="paciente" class="col-sm-2 control-label">Paciente</label>
              <div class="col-sm-2">
                <input type="text" class="form-control autocomplete-paciente" id="paciente" name='paciente' placeholder="Paciente" value="{{ old('paciente') }}" />
              </div>
              <label for="paciente" class="col-sm-1 control-label">Código</label>
              <div class="col-sm-1">
                <input type='text' class='form-control codigo_paciente_autocomplete' name='id_paciente' id='id_paciente' value="{{ $agendaDia['id_paciente'] or old('id_paciente') }}"  readonly="readonly"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="observacao">Observação</label>
              <div class='col-sm-7'>
              	<textarea class="form-control" id="observacao" name='observacao' placeholder="Observação">{{ $agendaDia['observacao'] or old('observacao') }}</textarea>
            	</div>
            </div>
            <div class='form-group'>  
              <div class="col-sm-offset-2 col-sm-9">    
                <button type='reset' class='btn'>Cancelar</button>
                <button type='submit' class='btn btn-primary'>Confirmar</button>    
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>