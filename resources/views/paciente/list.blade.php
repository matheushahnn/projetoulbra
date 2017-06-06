@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <a href="{{ url( '/home' ) }}">Início /</a>
  <a class='tela_atual' href="#">{{ $title }}</a>
</ol>
<div class="container-fluid form">

  @if( isset($errors) && count( $errors ) > 0 )
    <div class='alert alert-danger'>
      @foreach( $errors->all() as $erro )

        <p>{{ $erro }}</p>

      @endforeach
    </div>
  @endif
		<div class='row'>
			<div class="col-md-10">
				<form method='post' action="{{ route('paciente.search') }}" class='form-horizontal'>
					{!! csrf_field() !!}
					<div class="col-md-5">
						<input type="text" class="form-control" id="busca" name='busca' placeholder="Busca" value="{{ old('busca') }}" />
					</div>
					<label for="nome" class="col-sm-2 control-label">Buscar por:</label>
					<div class="col-sm-3">
			    	<select class='form-control' name='tipo_busca'>
			    		<option value='nome'>Nome</option>
			    		<option value="ficha_atendimento">Ficha Atendimento</option>
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
				<a href="{{ route('paciente.create') }}" class='btn btn-default btn-add'>
					<i class='glyphicon glyphicon-plus'></i>
					Novo
				</a>
			</div>
		</div>
    <div class="row">
    	<div class="col-md-12">
				<table class='table table-striped'>
					<thead>
						<tr>
							<th>Código</th>
							<th>Nome</th>
							<th>Data Nascimento</th>
							<th>Ficha de Atendimento</th>
							<th width='100px'>Ações</th>
						</tr>
					</thead>
					@forelse($pacientes as $paciente)
						<tr>
							<td>{{ $paciente->id }}</td>
							<td>{{ $paciente->nome }}</td>
							<td>{{ \Carbon\Carbon::parse( $paciente->dtnasc )->format( 'd/m/Y' ) }}</td>
							<td>{{ $paciente->ficha_atendimento }}</td>
							<td>
								<form method='post' action="{{ route('paciente.destroy', $paciente->id) }}">
							  	{!! method_field('DELETE') !!}
							  	{!! csrf_field() !!}
									<a href="{{route( "paciente.edit", $paciente->id )}}" class='actions edit'>
										<span class='glyphicon glyphicon-pencil'></span>
									</a>
									<button type='submit' class='btn-delete'>
										<span class='glyphicon glyphicon-trash'></span>
									</button>
								</form>
							</td>
						</tr>				
					@empty
						<tr>
							<td colspan="4">
								Nenhum paciente cadastrado
							</td>
						</tr>
					@endforelse	
					<tfoot>
					</tfoot>
				</table>
			</div>
		</div>

@endsection