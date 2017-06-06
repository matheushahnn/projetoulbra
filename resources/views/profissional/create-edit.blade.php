@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
  <a href="{{ url( '/home' ) }}">Início /</a>
  <a href="{{ route( 'profissional.index' ) }}">Lista de profissionais /</a>
  <a class='tela_atual' href="#">{{ $title }}</a>
</ol>
<div class="container-fluid form">
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
        <button type='submit' class='btn btn-primary'>Confirmar</button>    
        <button type='reset' class='btn btn-danger'>Cancelar</button>
      </div>
    </div>
  </form>
</div>
@endsection