@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastro de Procedimento</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('procedimento.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                            <label for="descricao" class="col-md-4 control-label">Descrição</label>

                            <div class="col-md-6">
                                <input id="descricao" type="descricao" class="form-control" name="descricao" value="{{ old('descricao') }}" required autofocus>

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('valor') ? ' has-error' : '' }}">
                            <label for="valor" class="col-md-4 control-label">Valor</label>

                            <div class="col-md-2">
                                <div class='input-group'>

                                    <span class="input-group-addon">R$</span>
                                    <input id="valor" type="valor" class="form-control" name="valor" required>

                                    @if ($errors->has('valor'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('valor') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Confirmar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
