@extends('layout')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col col-12">

                <h1 class="text-center"><strong>Adicionar Insumo</strong></h1>
                <form action="{{ asset('painel/insumos/adicionar') }}" method="POST">
                    @csrf

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="nomeInsumo" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nomeInsumo" name="nome" placeholder="Nome do Insumo"
                            maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="descricaoInsumo" class="form-label">Descrição</label>
                        <textarea class="form-control" name="descricao" id="descricaoInsumo" rows="5"
                            placeholder="Descricao do Insumo" maxlength="255" required></textarea>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="precoInsumo" class="form-label">Preço</label>
                        <input type="text" class="form-control money" id="precoInsumo" name="preco"
                            placeholder="Preço do Insumo" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="quantidadeInsumo" class="form-label">Estoque</label>
                        <input type="number" class="form-control" id="quantidadeInsumo" name="estoque"
                            placeholder="Quantidade do Insumo" onKeyPress="if(this.value.length==10) return false;"
                            onchange="if(this.value.length>10){this.value = ''}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="consumoInsumo" class="form-label">Consumo</label>
                        <input type="number" class="form-control" id="consumoInsumo" name="consumo"
                            placeholder="Consumo do Insumo" onKeyPress="if(this.value.length==10) return false;"
                            onchange="if(this.value.length>10){this.value = ''}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                        <a href="{{ asset('painel/insumos') }}" class="btn btn-secondary mr-1"><i
                                class="fas fa-times"></i> Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Adicionar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
