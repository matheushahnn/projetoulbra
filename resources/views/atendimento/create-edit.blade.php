@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <a href="{{ url( '/home' ) }}">Início /</a>
  <a href="{{ route( 'atendimento.index' ) }}">Lista de atendimentos /</a>
  <a class='tela_atual' href="#">{{ $title }}</a>
</ol>
<div class="container form" id='create_atendimento'>
  @if ( isset( $atendimento ) )
  	<form method='post' action="{{ route('atendimento.update', $atendimento->id) }}" class='form-horizontal'>

  	{!! method_field('PUT') !!}

  @else
  	<form method='post' action="{{ route('atendimento.store') }}" class='form-horizontal'>
  @endif
  	
  @if( isset($errors) && count( $errors ) > 0 )
  	<div class='alert alert-danger'>
  		@foreach( $errors->all() as $erro )

  			<p>{{ $erro }}</p>

  		@endforeach
  	</div>
  @endif

  	{!! csrf_field() !!}
    <div class="form-group">
      <label for="paciente" class="col-sm-2 control-label">Paciente</label>
      <div class="col-sm-4">
        <input type="text" class="form-control autocomplete-paciente" id="paciente" name='paciente' placeholder="Paciente" value="{{ $agenda_paciente->paciente or old('paciente') }}" />
        <input type='hidden' class='codigo_paciente_autocomplete' name='id_paciente' id='id_paciente' value={{ $agenda_paciente->id_paciente or old('id_paciente') }}/>
      </div>
    </div>
  	<div class="form-group">
      <label for="profissional" class="col-sm-2 control-label">Profissional</label>
      <div class="col-sm-4">
      	<input type="text" class="form-control autocomplete-profissional" id="profissional" name='profissional' placeholder="Profissional" value="{{ $atendimento->profissional or old('profissional') }}" />
        <input type='hidden' class='codigo_profissional_autocomplete' name='id_profissional' id='id_profissional' value={{ $atendimento->id_profissional or old('id_profissional') }}/>
    	</div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="data_inicial">Data</label>
      <div class='col-sm-2'>
        @if ( isset( $atendimento ) )
        <!-- Edição. -->
         <input type='text' maxlength='10' class="form-control campo_data" id="data" name='data' placeholder="Data Início" value="{{ \Carbon\Carbon::parse( $atendimento->data or old('data'))->format( 'd/m/Y' ) }}" />
        @else
        <!-- Novo. -->
         <input type='text' maxlength='10' class="form-control campo_data" id="data" name='data' placeholder="Data Início" value="{{ old('data') }}" />
        @endif
      </div>
      <label class="col-sm-2 control-label" for="data_inicial">Hora</label>
      <div class='col-sm-2'>
         <input type='text' maxlength='10' class="form-control campo_hora" id="hora" name='hora' placeholder="Hora Início" value="{{ old('hora') }}" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="procedimento">Procedimento</label>
      <div class='col-sm-2'>
         <input type="text" class="form-control autocomplete-procedimento" id="procedimento" name='procedimento' placeholder="Procedimento" value="{{ $atendimento->procedimento or old('procedimento') }}" />
        <input type='hidden' class='codigo_procedimento_autocomplete' name='id_procedimento' id='id_procedimento' value={{ $atendimento->id_procedimento or old('id_procedimento') }}/>
      </div>
      <label class="col-sm-2 control-label" for="quantidade">Quantidade</label>
      <div class='col-sm-2'>
         <input type="text" class="form-control autocomplete-quantidade" id="quantidade" name='quantidade' placeholder="Quantidade" value="{{ $atendimento->qtde_procedimento or old('quantidade') }}" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="observacao_procedimento">Observação</label>
      <div class='col-sm-4'>
         <textarea  class="form-control" id="observacao_procedimento" name='observacao_procedimento' placeholder="Observação do Procedimento">{{ $atendimento->observacao_procedimento or old('observacao_procedimento') }}</textarea>
      </div>
    	<div class="col-sm-4">  	
        <button type='button' id='btn_adicionar_procedimento' class='btn btn-info'>Adicionar</button>
      </div>
    </div>
    <div class="form-group">
      <div>
        <table class='table' id='tabela_procedimentos_atendimento'>
          <thead>
            <tr>
              <th class="col-sm-4">Procedimento</th>
              <th class="col-sm-2">Quantidade</th>
              <th class="col-sm-4">Observação</th>
              <th class="col-sm-2">Ações</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
    <div class='form-group'>  
      <div class="col-sm-offset-8 col-sm-4">    
  			<button type='submit' class='btn btn-success'>Confirmar</button>		
  			<button type='reset' class='btn btn-danger'>Cancelar</button>
  		</div>
  	</div>
  </form>
</div>
@endsection