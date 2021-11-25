@extends('layout')

@section('conteudo')

    @php
    date_default_timezone_set('America/Sao_Paulo');
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    @endphp

    <div class="container">
        <div class="row">
            <div class="col col-12">

                <h1 class="text-center"><strong>Adicionar Compra</strong></h1>
                <form action="{{ asset('painel/compras/adicionar') }}" method="POST">
                    @csrf

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="fornecedorCompra" class="form-label">Fornecedor</label>
                        <select class="custom-select" id="fornecedorCompra" name="fornecedor" required>
                            @foreach ($fornecedores as $fornecedor)
                                <option value="{{ $fornecedor->for_id }}">{{ $fornecedor->for_nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="dataCompra" class="form-label">Data</label>
                        <input id="dataCompra" class="form-control" value="{{ date('d/m/Y') }}" name="data" required
                            disabled>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="obsCompra" class="form-label">Observação</label>
                        <textarea name="observacao" id="obsCompra" rows="5" placeholder="Observação da Compra"
                            class="form-control" maxlength="255"></textarea>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                        <a href="{{ asset('painel/compras') }}" class="btn btn-secondary mr-1"><i
                                class="fas fa-times"></i> Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Adicionar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
