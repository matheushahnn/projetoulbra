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
  						<strong>Lista de Procedimentos</strong>
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
							<a href="{{ route('procedimento.create') }}" class='btn btn-primary btn-add'>
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
										<th>Código</th>
										<th>Descrição</th>
										<th>Observações</th>
										<th width='100px'>Ações</th>
									</tr>
									<tbody>
										@forelse($procedimentos as $procedimento)
											<tr title="{{ $procedimento->observacao }}">
												<td>{{ $procedimento->id }}</td>
												<td>{{ $procedimento->descricao }}</td>
												<td>{{ $procedimento->observacao }}</td>
												<td>
													<form method='post' action="{{ route('procedimento.destroy', $procedimento->id) }}">
												  	{!! method_field('DELETE') !!}
												  	{!! csrf_field() !!}
														<a href="{{route( "procedimento.edit", $procedimento->id )}}" class='actions edit'>
															<span class='fa fa-pencil'></span>
														</a>
														<button type='submit' class='btn-delete'>
															<span class='fa fa-trash'></span>
														</button>
													</form>
												</td>
											</tr>					
										@empty
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