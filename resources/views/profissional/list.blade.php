@extends('layouts.app')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Cadastros</h2>
        <ol class="breadcrumb">
            <li>
  						<a href="{{ url( '/home' ) }}">Início</a>
            </li>
            <li class="active">
  						<strong>{{ $title }}</strong>
            </li>
        </ol>
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
      			<div class="col-md-offset-10 col-md-2 text-right">
							<a href="{{ route('profissional.create') }}" class='btn btn-primary btn-add'>
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
											<th>Código Cadastro</th>
											<th width='100px'>Ações</th>
										</tr>
									</thead>
									<tbody>
										@forelse($profissionais as $profissional)
											<tr title="{{ $profissional->nome }}">
												<td>{{ $profissional->id }}</td>
												<td>{{ $profissional->nome }}</td>
												<td>{{ $profissional->codigo_cadastro }}</td>
												<td>
												<form method='post' action="{{ route('profissional.destroy', $profissional->id) }}">
											  	{!! method_field('DELETE') !!}
											  	{!! csrf_field() !!}
													<a href="{{route( "profissional.edit", $profissional->id )}}" class='actions edit'>
														<span class='fa fa-pencil'></span>
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
													Nenhum profissional cadastrado
												</td>
											</tr>
										@endforelse	
									</tbody>
									<tfoot>
									</tfoot>
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