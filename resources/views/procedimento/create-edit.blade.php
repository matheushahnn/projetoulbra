@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <a href="{{ url( '/home' ) }}">Início /</a>
  <a href="{{ route( 'procedimento.index' ) }}">Lista de procedimentos /</a>
  <a class='tela_atual' href="#">{{ $title }}</a>
</ol>
<div class="container-fluid form">

@if ( isset( $procedimento ) )
	<form method='post' action="{{ route('procedimento.update', $procedimento->id) }}" class='form-horizontal'>

	{!! method_field('PUT') !!}

@else

	<form method='post' action="{{ route('procedimento.store') }}" class='form-horizontal'>
	
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
    <label for="descricao" class="col-sm-2 control-label">Descrição</label>
    <div class="col-sm-9">
    	<input type="text" class="form-control" id="descricao" name='descricao' placeholder="Descrição" value="{{ $procedimento->descricao or old('descricao') }}" />
  	</div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="observacao">Observação</label>
    <div class='col-sm-9'>
    	<textarea class="form-control" id="observacao" name='observacao' placeholder="Observação">{{ $procedimento->observacao or old('observacao') }}</textarea>
  	</div>
  </div>
	<div class="form-group">
    <label class="col-sm-2 control-label" for="valor">Valor</label>
    <div class='col-sm-9'>
    	<input  value="{{ $procedimento->valor or old('valor') }}" type="text" class="form-control" id="valor" name='valor' placeholder="Valor" />
  	</div>
  </div>
  <div class='form-group'>  
  	<div class="col-sm-offset-2 col-sm-9">  	
			<button type='submit' class='btn btn-primary'>Confirmar</button>		
			<button type='reset' class='btn btn-danger'>Cancelar</button>
		</div>
	</div>
</form>

@endsection