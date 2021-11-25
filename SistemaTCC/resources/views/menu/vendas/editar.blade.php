@extends('layout')

@section('conteudo')

    @php
    date_default_timezone_set('America/Sao_Paulo');
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    @endphp

    <div class="container">
        <div class="row">
            <div class="col col-12">

                <h1 class="text-center"><strong>Alterar Venda</strong></h1>
                <form action="{{ asset("painel/vendas/editar/$request->ven_id") }}" method="POST">
                    @csrf

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="clienteVenda" class="form-label">Cliente</label>
                        <select class="custom-select" id="clienteVenda" name="cliente" disabled required>
                            <option value="{{ $cliente != null ? $cliente->cli_id : '' }}">
                                {{ $cliente != null ? $cliente->cli_nome : 'Não encontrado' }}
                            </option>
                        </select>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="dataVenda" class="form-label">Data</label>
                        <input id="dataVenda" class="form-control" value="{{ date('d/m/Y') }}" disabled required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="obsVenda" class="form-label">Observação</label>
                        <textarea name="observacao" id="obsVenda" rows="5" placeholder="Observação da Venda"
                            class="form-control" maxlength="255">{{ $venda->ven_observacao }}</textarea>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                        <a href="{{ asset('painel/vendas') }}" class="btn btn-secondary mr-1"><i
                                class="fas fa-times"></i>
                            Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pen"></i> Alterar</button>
                    </div>

                </form>
                <form action="{{ asset("painel/produto_venda/adicionar/$request->ven_id") }}" method="POST">
                    @csrf
                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <hr>
                    </div>

                    <h1 class="text-center"><strong>Adicionar Produto</strong></h1>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <div class="form-row">
                            <div class="form-group col-7">
                                <label for="produtoVenda" class="form-label">Produto</label>
                                <select class="custom-select" id="produtoVenda" name="produto"
                                    onchange="atualizaTotal(document.getElementById('produtoVenda'), document.getElementById('qtdeProduto'), document.getElementById('totalProduto'))"
                                    required>
                                    @foreach ($produtos as $produto)
                                        <option value="{{ $produto->prod_id }}"
                                            data-preco-venda="{{ $produto->prod_preco_venda }}">
                                            {{ $produto->prod_nome }} - R$
                                            {{ number_format($produto->prod_preco_venda, 2, ',', '.') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-2">
                                <label for="qtdeProduto">Quantidade</label>
                                <input type="number" min="1" class="form-control" id="qtdeProduto" name="qtde"
                                    onchange="atualizaTotal(document.getElementById('produtoVenda'), document.getElementById('qtdeProduto'), document.getElementById('totalProduto'))"
                                    required>
                            </div>
                            <div class="form-group col-3">
                                <label for="totalProduto">Total</label>
                                <input type="text" class="form-control" id="totalProduto" disabled>
                            </div>
                        </div>
                    </div>

                    @if ($venda->ven_conta_lancada == null)
                        <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i>
                                Adicionar</button>
                        </div>
                    @endif

                    @php
                        $totalVenda = collect($produtos_venda)->reduce(function ($carry, $item) {
                            $aux = $item->reduce(function ($carry, $item) {
                                return $carry + $item->iven_venda * $item->iven_quantidade;
                            }, 0);
                            return $carry + $aux;
                        }, 0);
                    @endphp

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <ul class="list-group">
                            <li class="list-group-item active">Produto Adicionados - Total: R$
                                {{ number_format($totalVenda, 2, ',', '.') }}</li>

                            <div class="accordion" id="accordionExample">
                                @foreach ($produtos_venda as $key => $value)
                                    @php
                                        $produto = collect($produtos)
                                            ->where('prod_id', '=', $key)
                                            ->first();

                                        $quantidadeAdicionada = collect($value)->reduce(function ($carry, $item) {
                                            return $carry + $item->iven_quantidade;
                                        }, 0);
                                    @endphp
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <div class="d-flex justify-content-between">
                                                <h5>{{ $produto->prod_nome }} - Quantidade:
                                                    {{ $quantidadeAdicionada }}</h5>
                                                <button onclick='collapseIconChange(this, "icon-{{ $key }}")'
                                                    class="btn btn-light" type="button" data-toggle="collapse"
                                                    data-target="#collapseOne-{{ $key }}" aria-expanded="false"
                                                    aria-controls="collapseOne">
                                                    <i id="icon-{{ $key }}" class="fas fa-chevron-down"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div id="collapseOne-{{ $key }}" class="collapse"
                                            aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <ul class="list-group">

                                                <li class="list-group-item d-flex align-items-center">
                                                    <div class="col col-4 text-center font-weight-bold ellipsis">
                                                        <span>Quantidade</span>
                                                    </div>
                                                    <div class="col col-4 text-center font-weight-bold ellipsis">
                                                        <span>Venda</span>
                                                    </div>
                                                    <div class="col col-4 text-center font-weight-bold ellipsis">
                                                        <span>Opções</span>
                                                    </div>
                                                </li>

                                                @foreach ($value as $produto_venda)
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <div class="col col-4 text-center">
                                                            <span>{{ $produto_venda->iven_quantidade }}</span>
                                                        </div>
                                                        <div class="col col-4 text-center">
                                                            <span>R$
                                                                {{ number_format($produto_venda->iven_venda, 2, ',', '.') }}</span>
                                                        </div>
                                                        <div class="col col-4 text-center">
                                                            <div style="word-spacing: 10px">
                                                                <a href="#" data-toggle="modal"
                                                                    data-target="#modalProdutoVenda-{{ $produto_venda->iven_id }}"><i
                                                                        class="fas fa-info-circle"></i></a>
                                                                <a href="#" data-toggle="modal"
                                                                    data-target="#modalProdutoVendaDel-{{ $produto_venda->iven_id }}"
                                                                    @if ($venda->ven_conta_lancada != null) style="pointer-events: none;" @endif><i
                                                                        class="text-{{ $venda->ven_conta_lancada == null ? 'danger' : 'secondary' }} fas fa-user-times"></i>
                                                                </a>

                                                            </div>
                                                        </div>
                                                    </li>

                                                    <!-- Modal -->
                                                    <div class="modal fade"
                                                        id="modalProdutoVenda-{{ $produto_venda->iven_id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Insumos Utilizados</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Fechar">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    @foreach ($produto_venda->insumosVenda as $insumosVenda)
                                                                        <h6>
                                                                            {{ $insumosVenda->insumo->ins_nome }} -
                                                                            Quantidade:
                                                                            {{ $produto_venda->iven_quantidade * $insumosVenda->insven_consumo }}
                                                                        </h6>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal -->
                                                    <div class="modal fade"
                                                        id="modalProdutoVendaDel-{{ $produto_venda->iven_id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="labelModalProdutoVendaDel-{{ $produto_venda->iven_id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="labelModalProdutoVendaDel-{{ $produto_venda->iven_id }}">
                                                                        Remover Produto da Venda</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Fechar">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Tem certeza que deseja remover o produto dessa venda?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Fechar</button>
                                                                    <a href="{{ asset("/painel/produto_venda/remover/$produto_venda->iven_id") }}"
                                                                        type="button" class="btn btn-primary">Confirmar</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </ul>
                    </div>

                </form>

                <div class="col col-10 offset-1 col-md-8 offset-md-2">
                    <hr>
                </div>

                @if ($venda->ven_conta_lancada == null)
                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3 d-flex justify-content-end">
                        <a href="{{ asset("/painel/contas_receber/adicionar/$venda->ven_id") }}"
                            class="btn btn-success"><em class="fas fa-receipt"></em> Lançar Conta a Receber</a>
                    </div>
                @elseif($venda->ven_conta_lancada != null)
                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3 d-flex justify-content-end">
                        <form action='{{ asset('painel/contas_receber/buscar') }}' method="POST">
                            @csrf
                            <input type="hidden" name="inputFiltro" value="{{ $venda->ven_id }}">
                            <button type="submit" class="btn btn-success mr-1"><em class="fas fa-receipt"></em> Conta
                                lançada em: {{ date('d/m/Y H:i', strtotime($venda->ven_conta_lancada)) }}</button>
                        </form>
                        <a class="btn btn-danger" data-toggle="modal" data-target="#modalVenda-{{ $venda->ven_id }}"><i
                                class="fas fa-user-times"></i> Remover Conta Lançada</a>
                    </div>
                @endif

                <!-- Modal -->
                <div class="modal fade" id="modalVenda-{{ $venda->ven_id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Remover Conta a Receber</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Tem certeza que deseja remover a conta a receber?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <a href="{{ asset("/painel/contas_receber/remover/$request->ven_id") }}" type="button"
                                    class="btn btn-primary">Confirmar</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
