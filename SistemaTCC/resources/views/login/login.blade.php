@extends('layout')

@section('conteudo')

<div class="container">

    <div class="row">
        <div class="col col-12">
            <h1 class="text-center"><strong>Acessar o Sistema</strong></h1>
            <form action="{{ asset('usuario/login') }}" method="POST">
                @csrf

                <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                    <label for="emailLogin" class="form-label">Email</label>
                    <input type="email" class="form-control" id="emailLogin" name="email" placeholder="Endereço de e-mail" required>
                </div>

                <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                    <label for="senhaLogin" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senhaLogin" name="password" placeholder="Senha" required>
                </div>

                <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Entrar</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
