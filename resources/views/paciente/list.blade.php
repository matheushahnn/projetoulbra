@extends('layouts.app')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Cadastros</h2>
        <ol class="breadcrumb">
            <li>
  						<a href="{{ url( '/home' ) }}">Início</a>
            </li>
            <li class="active">
  						<strong>Lista de pacientes</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">

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

  <div class="row">
	  <div class="col-md-12">
      <div class='ibox float-e-margins'>
      	<div class='ibox-content'>
      	<div class="row">
						<div class="col-sm-offset-10 col-md-2 text-right">
							<a href="{{ route('paciente.create') }}" class='btn btn-primary btn-add'>
								<i class='fa fa-plus'></i>
								Novo
							</a>
						</div>
					</div>
      		<div class="row">
	      		<div class="col-md-12">
		  		    <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example" >
					        <thead>
						        <tr>
										<th>Código</th>
										<th>Nome</th>
										<th>Data Nascimento</th>
										<th class="sorting">Ficha de Atendimento</th>
										<th width='100px'>Ações</th>
									</tr>
					        </thead>
					      	<tbody>
					    			@forelse($pacientes as $paciente)
										<tr class='gradA'>
											<td>{{ $paciente->id }}</td>
											<td>{{ $paciente->nome }}</td>
											<td>{{ \Carbon\Carbon::parse( $paciente->dtnasc )->format( 'd/m/Y' ) }}</td>
											<td>{{ $paciente->ficha_atendimento }}</td>
											<td>
												<form method='post' action="{{ route('paciente.destroy', $paciente->id) }}">
											  	{!! method_field('DELETE') !!}
											  	{!! csrf_field() !!}
													<a href="{{route( "paciente.edit", $paciente->id )}}" class='actions edit'>
														<i class='fa fa-edit'></i>
													</a>
													<button type='submit' class='btn-delete'>
														<span class='fa fa-trash'></span>
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
									</tbody>
									<tfoot></tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection