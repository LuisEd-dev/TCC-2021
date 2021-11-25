@extends('layout')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col col-12">

                <h1 class="text-center"><strong>Editar Usuário</strong></h1>
                <form action="{{ asset("painel/usuarios/editar/$usuario->usr_id") }}" method="POST">
                    @csrf

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="nomeUsuario" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nomeUsuario" name="nome" placeholder="Nome do Usuário"
                            value="{{ $usuario->usr_nome }}" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="emailUsuario" class="form-label">Email</label>
                        <input type="email" class="form-control" id="emailUsuario" name="email"
                            placeholder="Endereço de e-mail" value="{{ $usuario->usr_email }}" maxlength="255" readonly>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="senhaUsuario" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senhaUsuario" name="password"
                            placeholder="Nova Senha" maxlength="255">
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="senhaUsuario2" class="form-label">Confirme Nova Senha</label>
                        <input type="password" class="form-control" id="senhaUsuario2" name="confirmacao"
                            placeholder="Confirmação" maxlength="255">
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="statusUsuario" class="form-label">Status do Usuário</label>
                        <select class="custom-select" id="statusUsuario" name="status">
                            <option value="A" @if ($usuario->usr_status == 'A') selected @endif>Ativo</option>
                            <option value="I" @if ($usuario->usr_status == 'I') selected @endif>Inativo</option>
                        </select>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                        <a href="{{ asset('painel/usuarios') }}" class="btn btn-secondary mr-1"><i
                                class="fas fa-times"></i> Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pen"></i> Alterar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
