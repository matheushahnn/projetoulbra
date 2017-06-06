@extends('layouts.app')

@section('content')

@if( isset($errors) && count( $errors ) > 0 )
	<div class='alert alert-danger'>
		@foreach( $errors->all() as $erro )

			<p>{{ $erro }}</p>

		@endforeach
	</div>
@endif
<ol class="breadcrumb">
	<a href="{{ url( '/home' ) }}">Início /</a>
	<a class='tela_atual' href="#">{{ $title }}</a>
</ol>

<div class="container-fluid form">
		<div class='row'>
			<div class="col-md-10">
				<form method='post' action="{{ route('procedimento.search') }}" class='form-horizontal'>
					{!! csrf_field() !!}
					<div class="col-md-5">
						<input type="text" class="form-control" id="descricao_busca" name='descricao_busca' placeholder="Busca" value="{{ old('descricao_busca') }}" />
					</div>
					<label for="descricao" class="col-sm-2 control-label">Buscar por:</label>
					<div class="col-sm-3">
			    	<select class='form-control' name='tipo_busca'>
			    		<option value='descricao'>Descrição</option>
			    		<option value="observacao">Observação</option>
			    		<option value="id">Código</option>
			    	</select>
			  	</div>
					<div class="col-md-2">
						<button type='submit' class='btn btn-primary pull-right'>
						<i class='glyphicon glyphicon-search'></i>
							Buscar
						</button>
					</div>
				</form>
			</div>
			<div class="col-md-2">
				<a href="{{ route('procedimento.create') }}" class='btn btn-default btn-add'>
					<i class='glyphicon glyphicon-plus'></i>
					Novo
				</a>
			</div>
		</div>
    <div class="row">
    	<div class="col-md-12">
				<table class='table table-striped'>
					<tr>
						<th>Código</th>
						<th>Descrição</th>
						<th>Observações</th>
						<th width='100px'>Ações</th>
					</tr>
					@foreach($procedimentos as $procedimento)
					<tr title="{{ $procedimento->observacao }}">
						<td>{{ $procedimento->id }}</td>
						<td>{{ $procedimento->descricao }}</td>
						<td>{{ $procedimento->observacao }}</td>
						<td>
							<form method='post' action="{{ route('procedimento.destroy', $procedimento->id) }}">
						  	{!! method_field('DELETE') !!}
						  	{!! csrf_field() !!}
								<a href="{{route( "procedimento.edit", $procedimento->id )}}" class='actions edit'>
									<span class='glyphicon glyphicon-pencil'></span>
								</a>
								<button type='submit' class='btn-delete'>
									<span class='glyphicon glyphicon-trash'></span>
								</button>
							</form>
						</td>
					</tr>					
					@endforeach
				</table>
			</div>
		</div>

@endsection