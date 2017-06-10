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
            <a href="{{ route( 'atendimento.index' ) }}">Lista de Atendimentos</a>
          </li>
          <li class="active">
            <a><strong>Cadastro de Atendimentos</strong></a>
          </li>
      </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight" id="create_atendimento">
  <div class='row'>
    <div class="col-md-12">
      <div class='ibox float-e-margins'>
        <div class='ibox-content'>
          @if ( isset( $atendimento ) )
          	<form method='post' action="{{ route('atendimento.update', $atendimento->id) }}" class='form-horizontal'>

          	{!! method_field('PUT') !!}

          @else
          	<form method='post' action="{{ route('atendimento.store') }}" class='form-horizontal'>
          @endif
          	
          @if( isset($errors) && count( $errors ) > 0 )
          	<div class='alert alert-danger'>
          		@foreach( $errors->all() as $erro )

          			<p>{{ $erro }}</p>

          		@endforeach
          	</div>
          @endif
          	{!! csrf_field() !!}
            @if( isset( $agendaDia ) )
              <input type='hidden' value='{{ $agendaDia->id }}' name='id_agenda_dia' />
              <div class="form-group">
                <label for="hora_agenda" class="col-sm-2 control-label">Hora Agendamento</label>
                <div class="col-sm-1">
                  <input type="text" class="form-control" id="hora_agenda" name='hora_agenda' value="{{ \Carbon\Carbon::parse( $agendaDia->hora)->format( 'H:i' ) }}" disabled='' />
                </div>
                <label for="data_agenda" class="col-sm-2 control-label">Data Agendamento</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="data_agenda" name='data_agenda' value="{{ \Carbon\Carbon::parse( $agendaDia->data)->format( 'd/m/Y' ) }}" disabled='' />
                </div>
              </div>
              <div class="form-group">
                <label for="paciente" class="col-sm-2 control-label">Paciente</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control autocomplete-paciente" id="paciente" name='paciente' placeholder="Paciente" value="{{ $nomePaciente or old('paciente') }}" disabled='' />
                </div>
                <label for="paciente" class="col-sm-1 control-label">Código</label>
                <div class="col-sm-1">
                  <input type='text' class='form-control codigo_paciente_autocomplete' name='id_paciente' id='id_paciente' value="{{ $paciente->id or old('id_paciente') }}"  readonly="readonly" />
                </div>
              </div>
              <div class="form-group">
                <label for="profissional" class="col-sm-2 control-label">Profissional</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control autocomplete-profissional" id="profissional" name='profissional' placeholder="Profissional" value="{{ $nomeProfissional or old('profissional') }}" disabled=''/>
                </div>
                <label for="paciente" class="col-sm-1 control-label">Código</label>
                <div class="col-sm-1">
                  <input type='text' class='form-control codigo_profissional_autocomplete' name='id_profissional' id='id_profissional' value="{{ $profissional->id or old('id_profissional') }}"  readonly="readonly"/>
                </div>
              </div>
            @else
              <div class="form-group">
                <label for="paciente" class="col-sm-2 control-label">Paciente</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control autocomplete-paciente" id="paciente" name='paciente' placeholder="Paciente" value="{{ $atendimento->nome_paciente or old('paciente') }}" />
                </div>
                <label for="paciente" class="col-sm-1 control-label">Código</label>
                <div class="col-sm-1">
                  <input type='text' class='form-control codigo_paciente_autocomplete' name='id_paciente' id='id_paciente' value="{{ $atendimento->id_paciente or old('id_paciente') }}"  readonly="readonly" />
                </div>
              </div>
              <div class="form-group">
                <label for="profissional" class="col-sm-2 control-label">Profissional</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control autocomplete-profissional" id="profissional" name='profissional' placeholder="Profissional" value="{{ $atendimento->nome_profissional or old('profissional') }}" />
                </div>
                <label for="paciente" class="col-sm-1 control-label">Código</label>
                <div class="col-sm-1">
                  <input type='text' class='form-control codigo_profissional_autocomplete' name='id_profissional' id='id_profissional' value="{{ $atendimento->id_profissional or old('id_profissional') }}"  readonly="readonly"/>
                </div>
              </div>
            @endif
            <div class="form-group">
              <label class="col-sm-2 control-label" for="data_inicial">Data</label>
              <div class='col-sm-2'>
                @if ( isset( $atendimento ) )
                <!-- Edição. -->
                 <input type='text' maxlength='10' class="form-control campo_data" id="data" name='data' placeholder="Data Início" value="{{ \Carbon\Carbon::parse( $atendimento->data)->format( 'd/m/Y' ) }}" />
                @else
                <!-- Novo. -->
                 <input type='text' maxlength='10' class="form-control campo_data" id="data" name='data' placeholder="Data Início" value="{{ $data or old('data') }}" />
                @endif
              </div>
              <label class="col-sm-1 control-label" for="data_inicial">Hora</label>
              <div class='col-sm-1'>
                  @if ( isset( $atendimento ) )
                    <!-- Edição -->
                    <input type='text' maxlength='10' class="form-control campo_hora" id="hora" name='hora' placeholder="Hora Início" value="{{ $atendimento->hora or old('hora') }}" />
                  @else
                    <!-- Novo -->
                    <input type='text' maxlength='10' class="form-control campo_hora" id="hora" name='hora' placeholder="Hora Início" value="{{ $hora or old('hora') }}" />
                  @endif
                </div>
              </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="procedimento">Procedimento</label>
              <div class='col-sm-2'>
                 <input type="text" class="form-control autocomplete-procedimento" id="procedimento" name='procedimento' placeholder="Procedimento" value="{{ old('procedimento') }}" />
              </div>
              <label for="paciente" class="col-sm-1 control-label">Código</label>
              <div class="col-sm-1">
                <input type='text' class='form-control codigo_procedimento_autocomplete' name='id_procedimento' id='id_procedimento' value="{{ old('id_procedimento') }}"  readonly="readonly" />
              </div>
              <label class="col-sm-1 control-label" for="quantidade">Quantidade</label>
              <div class='col-sm-1'>
                 <input type="text" class="form-control autocomplete-quantidade" id="quantidade" name='quantidade' placeholder="Quantidade" value="{{ old('quantidade') or 1 }}" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="observacao_procedimento">Observação</label>
              <div class='col-sm-4'>
                 <textarea  class="form-control" id="observacao_procedimento" name='observacao_procedimento' placeholder="Observação do Procedimento">{{ old('observacao_procedimento') }}</textarea>
              </div>
            	<div class="col-sm-4">  	
                <button type='button' id='btn_adicionar_procedimento' class='btn btn-info'>Adicionar</button>
              </div>
            </div>
            <div class="form-group">
              <div>
                <table class='table' id='tabela_procedimentos_atendimento'>
                  <thead>
                    <tr>
                      <th class="col-sm-4">Procedimento</th>
                      <th class="col-sm-2">Quantidade</th>
                      <th class="col-sm-4">Observação</th>
                      <th class="col-sm-2">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if ( isset( $atendimento ) )
                      @forelse($procedimento_list as $k => $procedimento)
                        <tr>
                         <td>
                           <input type="hidden" name="procedimento_atendimentos[{{ $k }}][id_procedimento]" value="{{ $procedimento->id }}" />
                           {{ $procedimento->descricao }}
                         </td>
                         <td>
                           <input type="hidden" name="procedimento_atendimentos[{{ $k }}][quantidade]" value="{{ $procedimento->quantidade }}" />
                           {{ $procedimento->quantidade }}
                         </td>
                         <td>
                           <input type="hidden" name="procedimento_atendimentos[{{ $k }}][observacao]" value="{{ $procedimento->observacao }}"/>
                           {{ $procedimento->observacao }}
                         </td>
                         <td>
                           <span title="Remover procedimento" class="pointer text-center remover_procedimento fa fa-trash"></span>
                         </td>
                        </tr>
                      @empty

                      @endforelse
                    @endif
                  </tbody>
                </table>
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