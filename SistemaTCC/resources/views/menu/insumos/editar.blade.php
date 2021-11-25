@extends('layout')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col col-12">

                <h1 class="text-center"><strong>Alterar Insumo</strong></h1>
                <form action="{{ asset("painel/insumos/editar/$insumo->ins_id") }}" method="POST">
                    @csrf

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="nomeInsumo" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nomeInsumo" name="nome" placeholder="Nome do Insumo"
                            value="{{ $insumo->ins_nome }}" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="descricaoInsumo" class="form-label">Descrição</label>
                        <textarea class="form-control" name="descricao" id="descricaoInsumo" rows="5"
                            placeholder="Descricao do Insumo" maxlength="255"
                            required>{{ $insumo->ins_descricao }}</textarea>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="precoInsumo" class="form-label">Preço</label>
                        <input type="text" class="form-control money" id="precoInsumo" name="preco"
                            placeholder="Preço do Insumo" value="{{ $insumo->ins_preco }}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="quantidadeInsumo" class="form-label">Estoque</label>
                        <input type="number" class="form-control" id="quantidadeInsumo" name="estoque"
                            placeholder="Quantidade do Insumo" value="{{ $insumo->ins_estoque }}"
                            onKeyPress="if(this.value.length==10) return false;"
                            onchange="if(this.value.length>10){this.value = ''}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="consumoInsumo" class="form-label">Consumo</label>
                        <input type="number" class="form-control" id="consumoInsumo" name="consumo"
                            placeholder="Consumo do Insumo" value="{{ $insumo->ins_consumo }}"
                            onKeyPress="if(this.value.length==10) return false;"
                            onchange="if(this.value.length>10){this.value = ''}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                        <a href="{{ asset('painel/insumos') }}" class="btn btn-secondary mr-1"><i
                                class="fas fa-times"></i> Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pen"></i> Alterar</button>
                    </div>
                </form>

                <form action="{{ asset("painel/insumos_produtos/adicionar/$insumo->ins_id") }}" method="POST">
                    @csrf
                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <hr>
                    </div>

                    <h1 class="text-center"><strong>Relacionar Produto</strong></h1>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="produtoVenda" class="form-label">Produto</label>
                                <select class="custom-select" id="produtoVenda" name="produto" required>
                                    @php
                                        $aux = collect($insumos_produtos)->map(function ($value, $key) {
                                            return $value->tb_produtos_prod_id;
                                        });
                                        $produtosFiltrados = collect($produtos)->filter(function ($value, $key) use ($aux) {
                                            if (!collect($aux)->contains($value->prod_id)) {
                                                return $value;
                                            }
                                        });
                                    @endphp
                                    @foreach ($produtosFiltrados as $produto)
                                        <option value="{{ $produto->prod_id }}">{{ $produto->prod_nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <ul class="list-group">
                            <li class="list-group-item active">Produtos Relacionados</li>
                            @foreach ($insumos_produtos as $insumo_produto)
                                <li class="list-group-item d-flex justify-content-between ellipsis">
                                    {{ $insumo_produto->produto->prod_nome }}
                                    <div style="word-spacing: 10px">
                                        <a data-toggle="modal"
                                            data-target="#modalInsumoProduto-{{ $insumo_produto->insprod_id }}"><i
                                                class="text-danger fas fa-user-times"></i></a>
                                    </div>
                                </li>

                                <!-- Modal -->
                                <div class="modal fade" id="modalInsumoProduto-{{ $insumo_produto->insprod_id }}"
                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Remover Produto</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Fechar">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Tem certeza que deseja desvincular o produto?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Fechar</button>
                                                <a href="{{ asset("/painel/insumos_produtos/remover/$insumo_produto->insprod_id") }}"
                                                    type="button" class="btn btn-primary">Confirmar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
