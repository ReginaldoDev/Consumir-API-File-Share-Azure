@extends('layouts.app', ["current" => "parametros"])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Parâmetros</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form action="/parametros" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Chave Key 1 Azure</label>
                            <input type="text" class="form-control" name="CHAVE_ACCESSKEY" id="CHAVE_ACCESSKEY"
                                placeholder="CHAVE_ACCESSKEY" value="{{ $par->CHAVE_ACCESSKEY }}">
                        </div>
                        <div class="form-group">
                            <label for="">Usuário do container</label>
                            <input type="text" class="form-control" value="{{ $par->USER_ACCOUNT }}" name="USER_ACCOUNT" id="USER_ACCOUNT"
                                placeholder="USER_ACCOUNT">
                        </div>
                        <div class="form-group">
                            <label for="">Nome do container</label>
                            <input type="text" class="form-control" value="{{ $par->CONTAINER_NAME }}" name="CONTAINER_NAME" id="CONTAINER_NAME"
                                placeholder="CONTAINER_NAME">
                        </div>
                        <div class="form-group">
                            <label for="">Versão do File Share</label>
                            <input type="text" class="form-control" value="{{ $par->VERSION }}" name="VERSION" id="VERSION"
                                placeholder="VERSION">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection