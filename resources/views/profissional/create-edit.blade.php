@extends('layouts.app')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">

  <div class="col-lg-10">
      <h2>Cadastros</h2>
      <ol class="breadcrumb">
        <li>
          <a href="{{ url( '/home' ) }}">Início</a>
        </li>
        <li>
          <a href="{{ route( 'procedimento.index' ) }}">Lista de Profissionais</a>
        </li>
        <li class="active">
          <a><strong>{{ $title }}</strong></a>
        </li>
    </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class='row'>
    <div class="col-md-12">
      <div class='ibox float-e-margins'>
        <div class='ibox-content'>
          @if ( isset( $profissional ) )
            <form method='post' action="{{ route('profissional.update', $profissional->id) }}" class='form-horizontal'>

            {!! method_field('PUT') !!}

          @else
            <form method='post' action="{{ route('profissional.store') }}" class='form-horizontal'>
          @endif
            
          @if( isset($errors) && count( $errors ) > 0 )
            <div class='alert alert-danger'>
              @foreach( $errors->all() as $erro )

                <p>{{ $erro }}</p>

              @endforeach
            </div>
          @endif

            {!! csrf_field() !!}
            <div class="form-group">
            <div class="form-group">
              <label for="nome" class="col-sm-2 control-label">Nome</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="nome" name='nome' placeholder="Descrição" value="{{ $profissional->nome or old('nome') }}" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="dtnasc">Data de Nascimento</label>
              <div class='col-sm-2'>
                @if ( isset( $profissional ) )
                <!-- Edição. -->
                 <input type='text' maxlength='10' class="form-control campo_data" id="dtnasc" name='dtnasc' placeholder="Data de Nascimento" value="{{ \Carbon\Carbon::parse( $profissional->dtnasc)->format( 'd/m/Y' ) }}" />
                @else
                <!-- Novo. -->
                 <input type='text' maxlength='10' class="form-control campo_data" id="dtnasc" name='dtnasc' placeholder="Data de Nascimento" value="{{ old('dtnasc') }}" />
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="codigo_cadastro">Código do Cadastro</label>
              <div class='col-sm-2'>
                <input maxlength='10' value="{{ $profissional->codigo_cadastro or old('codigo_cadastro') }}" type="text" class="form-control mask_numero" id="codigo_cadastro" name='codigo_cadastro' placeholder="Código do Cadastro" />
              </div>
            </div>
            <div class='form-group'>  
              <div class="col-sm-offset-2 col-sm-9">    
                <button type='reset' class='btn'>Cancelar</button>
                <button type='submit' class='btn btn-primary'>Confirmar</button>    
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection