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
  						<strong>{{ $title }}</strong>
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
							<a href="{{ route('agenda_profissional.create') }}" class='btn btn-primary btn-add'>
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
											<th>Profissional</th>
											<th>Data Inicial</th>
											<th>Data Final</th>
											<th>Hora Inicial</th>
											<th>Hora Final</th>
											<th>Status</th>
											<th width='100px'>Ações</th>
										</tr>
									</thead>
									<tbody>
										@forelse($agendas as $agenda)
										<tr title="{{ $agenda->nome_profissional }}">
											<td>{{ $agenda->nome_profissional }}</td>
											<td>{{ \Carbon\Carbon::parse($agenda->data_inicial)->format( 'd/m/Y' ) }}</td>
											<td>{{ \Carbon\Carbon::parse($agenda->data_final)->format( 'd/m/Y' ) }}</td>
											<td>{{ substr($agenda->hora_inicial,0, -3) }}</td>
											<td>{{ substr($agenda->hora_final, 0, -3) }}</td>
											<td>{{ $agenda->status }}</td>
											<td>
												<form method='post' action="{{ route('agenda_profissional.destroy', $agenda->id) }}">
											  	{!! method_field('DELETE') !!}
											  	{!! csrf_field() !!}
													<a href="{{route( "agenda_profissional.edit", $agenda->id )}}" class='actions edit'>
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