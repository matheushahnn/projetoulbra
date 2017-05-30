@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <a href="{{ url( '/home' ) }}">Início /</a>
  <a href="{{ route( 'agenda_profissional.index' ) }}">Lista de agenda_profissionals /</a>
  <a class='tela_atual' href="#">{{ $title }}</a>
</ol>
<div class="container form">
  @if ( isset( $agenda_profissional ) )
  	<form method='post' action="{{ route('agenda_profissional.update', $agenda_profissional->id) }}" class='form-horizontal'>

  	{!! method_field('PUT') !!}

  @else
  	<form method='post' action="{{ route('agenda_profissional.store') }}" class='form-horizontal'>
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
  	<div class="form-group">
      <label for="profissional" class="col-sm-2 control-label">Profissional</label>
      <div class="col-sm-9">
      	<input type="text" class="form-control autocomplete-profissional" id="profissional" name='profissional' placeholder="Descrição" value="{{ $profissional->pessoa->nome or old('profissional') }}" />
        <input type='hidden' class='codigo_profissional_autocomplete' name='id_profissional' id='id_profissional' value="{{ $agenda_profissional->id_profissional or old('id_profissional') }}"/>
    	</div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="data_inicial">Data de Inicial</label>
      <div class='col-sm-2'>
        @if ( isset( $agenda_profissional ) )
        <!-- Edição. -->
         <input type='text' maxlength='10' class="form-control campo_data" id="data_inicial" name='data_inicial' placeholder="Data Início" value="{{ \Carbon\Carbon::parse( $agenda_profissional->data_inicial)->format( 'd/m/Y' ) }}" />
        @else
        <!-- Novo. -->
         <input type='text' maxlength='10' class="form-control campo_data" id="data_inicial" name='data_inicial' placeholder="Data Início" value="{{ old('data_inicial') }}" />
        @endif
      </div>
      <label class="col-sm-2 control-label" for="data_inicial">Hora de Inicial</label>
      <div class='col-sm-2'>
         <input type='text' maxlength='10' class="form-control campo_hora" id="hora_inicial" name='hora_inicial' placeholder="Hora Início" value="{{ $agenda_profissional->hora_inicial or old('hora_inicial') }}" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="data_inicial">Data de Final</label>
      <div class='col-sm-2'>
        @if ( isset( $agenda_profissional ) )
        <!-- Edição. -->
         <input type='text' maxlength='10' class="form-control campo_data" id="data_final" name='data_final' placeholder="Data Final" value="{{ \Carbon\Carbon::parse( $agenda_profissional->data_final)->format( 'd/m/Y' ) }}" />
        @else
        <!-- Novo. -->
         <input type='text' maxlength='10' class="form-control campo_data" id="data_final" name='data_final' placeholder="Data Final" value="{{ old('data_final') }}" />
        @endif
      </div>
      <label class="col-sm-2 control-label" for="data_final">Hora de Final</label>
      <div class='col-sm-2'>
         <input type='text' maxlength='10' class="form-control campo_hora" id="hora_final" name='hora_final' placeholder="Hora Final" value="{{ $agenda_profissional->hora_final or old('hora_final') }}" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="ficha_atendimento">Duração</label>
      <div class='col-sm-2'>
         <input type='text' maxlength='2' class="form-control" id="duracao" name='duracao' placeholder="Duração" value="{{ $agenda_profissional->duracao or old('duracao') }}" />
      </div>
    </div>
  	<div class="form-group">
      <label class="col-sm-2 control-label" for="ficha_atendimento">Status</label>
      <div class='col-sm-2'>
      	<select class="form-control" name='status'>
          <option id="status" value=''>Selecione</option>
          <option id="status" value='1' {{ ( ( $agenda_profissional->status == true ) ? 'selected' : '') }}>Ativo</option>
          <option id="status" value='0' {{ ( ( $agenda_profissional->status == false ) ? 'selected' : '') }}>Inativo</option>
        </select>
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