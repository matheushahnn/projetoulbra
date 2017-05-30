<div class="container form">
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

  <div class='row'>
    <div class='col-sm-12'>
      <p> <b>Profissional: </b> {{ $agendaDia['nome_profissional'] or old( 'nome_profissional' ) }}</p>
    </div>    
  </div>
  <div class='row'>
    <div class='col-sm-6'>
      <p> <b>Hora: </b> {{ $agendaDia['hora_selecionada'] }}</p>
    </div>    
    <div class='col-sm-6'>
      <p> <b>Data: </b> {{ $agendaDia['dia_selecionado'] }}</p>
    </div>    
  </div>
	<div class="form-group">
    <label for="id_paciente" class="col-sm-2 control-label">Paciente</label>
    <div class="col-sm-9">
      <input type="text" class="form-control autocomplete-paciente" id="paciente" name='paciente' placeholder="Paciente" value="{{ old('paciente') }}" />
    	<input type='hidden' class='codigo_paciente_autocomplete' name='id_paciente' id='id_paciente' value="{{ $agendaDia['id_paciente'] or old('id_paciente') }}" />
  	</div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="observacao">Observação</label>
    <div class='col-sm-9'>
    	<textarea class="form-control" id="observacao" name='observacao' placeholder="Observação">{{ $agendaDia['observacao'] or old('observacao') }}</textarea>
  	</div>
  </div>
  <div class='form-group'>  
  	<div class="col-sm-offset-2 col-sm-9">  	
			<button type='submit' class='btn btn-primary'>Confirmar</button>		
			<button type='reset' class='btn btn-danger'>Cancelar</button>
		</div>
	</div>
</form>