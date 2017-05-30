@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <a href="{{ url( '/home' ) }}">Início /</a>
  <a class='tela_atual' href="#">{{ $title }}</a>
</ol>
@if( isset($errors) && count( $errors ) > 0 )
	<div class='alert alert-danger'>
		@foreach( $errors->all() as $erro )

			<p>{{ $erro }}</p>

		@endforeach
	</div>
@endif

<div class="container-fluid form">
		<div class='row'>
			<div class="col-md-12">
				<form method='post' action="{{ route('agenda_profissional.search') }}" class='form-horizontal'>
					<div class="container-fluid">
				  	<div class="row">
				  		<div class='col-sm-2'>
			         	<input type='text' maxlength='10' class="form-control campo_data" id="data_inicial" name='data_inicial' placeholder="Data Início" value="{{ old('data_inicial') }}" />
			      	</div>
				  		<div class='col-sm-2'>
			         	<input type='text' maxlength='10' class="form-control campo_data" id="data_final" name='data_final' placeholder="Data Final" value="{{ old('data_final') }}" />
			      	</div>
				      <div class='col-sm-offset-1 col-sm-2'>
				         <input type='text' maxlength='10' class="form-control campo_hora" id="hora_inicial" name='hora_inicial' placeholder="Hora Início" value="{{ old('hora_inicial') }}" />
				      </div>
				      <div class='col-sm-2'>
				         <input type='text' maxlength='10' class="form-control campo_hora" id="hora_final" name='hora_final' placeholder="Hora Final" value="{{ old('hora_final') }}" />
				      </div>
				  	</div>		
				  	<div class="espaco_entre_input"> </div>
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
								<a href="{{ route('agenda_profissional.create') }}" class='btn btn-default btn-add'>
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
						<th>Profissional</th>
						<th>Data Inicial</th>
						<th>Data Final</th>
						<th>Hora Inicial</th>
						<th>Hora Final</th>
						<th>Status</th>
						<th width='100px'>Ações</th>
					</tr>
					@foreach($agendas as $agenda)
					<tr title="{{ $agenda->nome_profissional }}">
						<td>{{ $agenda->nome_profissional }}</td>
						<td>{{ \Carbon\Carbon::parse($agenda->data_inicial)->format( 'd/m/Y' ) }}</td>
						<td>{{ \Carbon\Carbon::parse($agenda->data_final)->format( 'd/m/Y' ) }}</td>
						<td>{{ substr($agenda->hora_inicial,0, -3) }}</td>
						<td>{{ substr($agenda->hora_final, 0, -3) }}</td>
						<td>{{ $agenda->status }}</td>
						<td>
							<a href="{{route( "agenda_profissional.edit", $agenda->id )}}" class='actions edit'>
								<span class='glyphicon glyphicon-pencil'></span>
							</a>
							<a href='#' class='actions delete'>
								<span class='glyphicon glyphicon-trash'></span>
							</a>
						</td>
					</tr>					
					@endforeach
				</table>
			</div>
		</div>

@endsection