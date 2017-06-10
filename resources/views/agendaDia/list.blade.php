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
  						<strong>Lista dos Agendamentos do Dia</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight janela">

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
      	<div class="row">
					<form method='post' id='form_dia_profissional' action="{{ route('procedimento.store') }}" class='form-horizontal'>
						<label class='col-sm-1 control-label'>Profissional</label>
						<div class='col-sm-3'>
							<input type='text' class="form-control autocomplete-profissional" name='profissional' id='profissional' placeholder="Profissional" value='' />
						</div>
						<label class='col-sm-1 control-label'>Códigio</label>
						<div class='col-sm-1'>
							<input type='text' class='form-control codigo_profissional_autocomplete' name='id_profissional' id='id_profissional' readonly="readonly"/>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	  <div class="row">
		  <div class="col-md-4">
	      <div class='ibox float-e-margins'>
	      	<div class='ibox-content'>
	      		<div class='text-center'>
							<div id="datepicker_agenda" class='m-r-sd inline'></div>
						</div>
					</div>
				</div>
			</div>
			<div class='col-sm-8'>
				<div class='ibox float-e-margins'>
      		<div class='ibox-content'>
						<div id='horarios_dia_profissional' class='h-300'></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection