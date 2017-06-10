@extends('layouts.app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">

  <div class="col-lg-10">
        <h2>Cadastros</h2>
        <ol class="breadcrumb">
          <li>
            <a href="{{ url( '/home' ) }}">Início</a>
          </li>
          <li>
            <a href="{{ route( 'paciente.index' ) }}">Lista de Pacientes</a>
          </li>
          <li class="active">
            <a><strong>{{ $title }}</strong></a>
          </li>
      </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class='row'>
    <div class="col-md-12">
      <div class='ibox float-e-margins'>
        <div class='ibox-content'>
          @if ( isset( $paciente ) )
          	<form method='post' action="{{ route('paciente.update', $paciente->id) }}" class='form-horizontal'>

          	{!! method_field('PUT') !!}

          @else
          	<form method='post' action="{{ route('paciente.store') }}" class='form-horizontal'>
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
              <label for="nome" class="col-sm-2 control-label">Nome</label>
              <div class="col-sm-9">
              	<input type="text" class="form-control" id="nome" name='nome' placeholder="Nome" value="{{ $pessoa->nome or old('nome') }}" />
            	</div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="dtnasc">Data de Nascimento</label>
              <div class='col-sm-2'>
                @if ( isset( $paciente ) )
                <!-- Edição. -->
                 <input type='text' maxlength='10' class="form-control campo_data" id="dtnasc_paciente" name='dtnasc' placeholder="Data de Nascimento" value="{{ \Carbon\Carbon::parse( $pessoa->dtnasc)->format( 'd/m/Y' ) }}" />
                @else
                <!-- Novo. -->
                 <input type='text' maxlength='10' class="form-control campo_data" id="dtnasc_paciente" name='dtnasc' placeholder="Data de Nascimento" value="{{ old('dtnasc') }}" />
                @endif
            	</div>
            </div>
          	<div class="form-group">
              <label class="col-sm-2 control-label" for="ficha_atendimento">Ficha de Atendimento</label>
              <div class='col-sm-2'>
              	<input maxlength='10' value="{{ $paciente->ficha_atendimento or old('ficha_atendimento') }}" type="text" class="form-control" id="ficha_atendimento" name='ficha_atendimento' placeholder="Ficha de Atendimento" />
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
@endsection