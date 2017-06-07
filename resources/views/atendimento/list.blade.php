@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <a href="{{ url( '/home' ) }}">Início /</a>
  <a class='tela_atual' href="#">{{ $title }}</a>
</ol>

<!-- Errors -->
@if( isset($errors) && count( $errors ) > 0 )
  <div class='alert alert-danger'>
    @foreach( $errors->all() as $erro )

      <p>{{ $erro }}</p>

    @endforeach
  </div>
@endif

<!-- Success -->
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif


<div class="container-fluid form">
		<div class='row'>
			<div class="col-md-12">
				<form method='post' action="{{ route('atendimento.search') }}" class='form-horizontal'>
					<div class="container-fluid">
				  	<div class="row">
							{!! csrf_field() !!}
							<div class="col-md-4">
								<input type="text" class="form-control" id="busca" name='busca' placeholder="Busca" value="{{ old('busca') }}" />
							</div>
							<label for="nome" class="col-sm-2 control-label">Buscar por:</label>
							<div class="col-sm-3">
					    	<select class='form-control' name='tipo_busca'>
					    		<option value='nome'>Nome Profissional</option>
					    	</select>
					  	</div>
							<div class="col-md-2">
								<button type='submit' class='btn btn-primary pull-right'>
								<i class='glyphicon glyphicon-search'></i>
									Buscar
								</button>
							</div>
							<div class="col-md-1">
								<a href="{{ route('atendimento.create') }}" class='btn btn-default btn-add'>
									<i class='glyphicon glyphicon-plus'></i>
									Novo
								</a>
							</div>
				  	</div>
				</form>
			</div>			
		</div>
    <div class="row">
    	<div class="col-md-12">
				<table class='table table-striped'>
					<tr>
						<th>Paciente</th>
						<th>Profissional</th>
						<th>Data</th>
						<th>Hora</th>
						<th width='100px'>Ações</th>
					</tr>
					@foreach($atendimentos as $atendimento)
					<tr>
						<td>{{ $atendimento->nome_paciente }}</td>
						<td>{{ $atendimento->nome_profissional }}</td>
						<td>{{ \Carbon\Carbon::parse($atendimento->data)->format( 'd/m/Y' ) }}</td>
						<td>{{ substr($atendimento->hora,0, -3) }}</td>
						<td>
							<form method='post' action="{{ route('atendimento.destroy', $atendimento->id) }}">
						  	{!! method_field('DELETE') !!}
						  	{!! csrf_field() !!}
								<a href="{{route( "atendimento.edit", $atendimento->id )}}" class='actions edit'>
									<span class='glyphicon glyphicon-pencil'></span>
								</a>
								<button button='submit' class='btn-delete'>
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