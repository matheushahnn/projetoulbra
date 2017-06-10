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
          <a href="{{ route( 'procedimento.index' ) }}">Lista de Procedimentos</a>
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