@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
	<a href="{{ url( '/home' ) }}">Início /</a>
	<a class='tela_atual' href="#">{{ $title }}</a>
</ol>
<div class="container-fluid janela form">

		@if( isset($errors) && count( $errors ) > 0 )
			<div class='alert alert-danger'>
				@foreach( $errors->all() as $erro )

					<p>{{ $erro }}</p>

				@endforeach
			</div>
		@endif

		<div class='row form-superior'>
			<form method='post' id='form_dia_profissional' action="{{ route('procedimento.store') }}" class='form-horizontal'>
				<label class='col-sm-1 control-label'>Profissional</label>
				<div class='col-sm-3'>
					<input type='text' class="form-control autocomplete-profissional" name='profissional' id='profissional' placeholder="Profissional" value='' />
					<input type='hidden' class='codigo_profissional_autocomplete' name='id_profissional' id='id_profissional' />
				</div>
			</form>
		</div>
		<div class='row'>
			<div class='col-sm-3'>
				<div id="datepicker_agenda"></div>
			</div>
			<div class='col-sm-9'>
				
				<div id='horarios_dia_profissional'>
				
				</div>
			</div>
		</div>
</div>

@endsection