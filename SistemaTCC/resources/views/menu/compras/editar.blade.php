@extends('layout')

@section('conteudo')

    @php
    date_default_timezone_set('America/Sao_Paulo');
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    @endphp

    <div class="container">
        <div class="row">
            <div class="col col-12">

                <h1 class="text-center"><strong>Alterar Compra</strong></h1>
                <form action="{{ asset("painel/compras/editar/$compra->cmp_id") }}" method="POST">
                    @csrf

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="fornecedorCompra" class="form-label">Fornecedor</label>
                        <select class="custom-select" id="fornecedorCompra" name="fornecedor" disabled required>
                            @foreach ($fornecedores as $fornecedor)
                                <option value="{{ $fornecedor->for_id }}">{{ $fornecedor->for_nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="dataCompra" class="form-label">Data</label>
                        <input id="dataCompra" class="form-control" value="{{ date(' d/m/Y') }}" disabled required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="obsCompra" class="form-label">Observação</label>
                        <textarea name="observacao" id="obsCompra" rows="5" placeholder="Observação da Compra"
                            class="form-control" maxlength="255">{{ $compra->cmp_observacao }}</textarea>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                        <a href="{{ asset('painel/compras') }}" class="btn btn-secondary mr-1"><i
                                class="fas fa-times"></i>
                            Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pen"></i> Alterar</button>
                    </div>

                </form>
                <form action="{{ asset("painel/insumo_compra/adicionar/$compra->cmp_id") }}" method="POST">
                    @csrf
                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <hr>
                    </div>

                    <h1 class="text-center"><strong>Adicionar Insumo</strong></h1>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <div class="form-row">
                            <div class="form-group col-7">
                                <label for="insumoCompra" class="form-label">Insumo</label>
                                <select class="custom-select" id="insumoCompra" name="insumo"
                                    onchange="atualizaTotal(document.getElementById('insumoCompra'), document.getElementById('qtdeInsumo'), document.getElementById('totalInsumo'))"
                                    required>
                                    @foreach ($insumos as $insumo)
                                        <option value="{{ $insumo->ins_id }}"
                                            data-preco-venda="{{ $insumo->ins_preco }}">{{ $insumo->ins_nome }} -
                                            R$ {{ number_format($insumo->ins_preco, 2, ',', '.') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-2">
                                <label for="qtdeInsumo">Quantidade</label>
                                <input type="number" min="1" class="form-control" id="qtdeInsumo" name="qtde"
                                    onchange="atualizaTotal(document.getElementById('insumoCompra'), document.getElementById('qtdeInsumo'), document.getElementById('totalInsumo'))"
                                    required>
                            </div>
                            <div class="form-group col-3">
                                <label for="totalInsumo">Total</label>
                                <input type="text" class="form-control" id="totalInsumo" disabled>
                            </div>
                        </div>
                    </div>

                    @if ($compra->cmp_conta_lancada == null)
                        <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i>
                                Adicionar</button>
                        </div>
                    @endif

                    @php
                        $totalCompra = collect($insumos_compra)->reduce(function ($carry, $item) {
                            $aux = $item->reduce(function ($carry, $item) {
                                return $carry + $item->icmp_preco * $item->icmp_quantidade;
                            }, 0);
                            return $carry + $aux;
                        }, 0);
                    @endphp

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <ul class="list-group">
                            <li class="list-group-item active">Insumos Adicionados - Total: R$
                                {{ number_format($totalCompra, 2, ',', '.') }}</li>

                            <div class="accordion" id="accordionExample">
                                @foreach ($insumos_compra as $key => $value)
                                    @php
                                        $insumo = collect($insumos)
                                            ->where('ins_id', '=', $key)
                                            ->first();

                                        $quantidadeAdicionada = collect($value)->reduce(function ($carry, $item) {
                                            return $carry + $item->icmp_quantidade;
                                        }, 0);
                                    @endphp
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <div class="d-flex justify-content-between">
                                                <h5>{{ $insumo->ins_nome }} - Quantidade: {{ $quantidadeAdicionada }}
                                                </h5>
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
                                                        <span>Preço</span>
                                                    </div>
                                                    <div class="col col-4 text-center font-weight-bold ellipsis">
                                                        <span>Opções</span>
                                                    </div>
                                                </li>

                                                @foreach ($value as $insumo_compra)
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <div class="col col-4 text-center">
                                                            <span>{{ $insumo_compra->icmp_quantidade }}</span>
                                                        </div>
                                                        <div class="col col-4 text-center">
                                                            <span>R${{ number_format($insumo_compra->icmp_preco, 2, ',', '.') }}</span>
                                                        </div>
                                                        <div class="col col-4 text-center">
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#modalInsumoCompraDel-{{ $insumo_compra->icmp_id }}"
                                                                @if ($compra->cmp_conta_lancada != null) style="pointer-events: none;" @endif><i
                                                                    class="text-{{ $compra->cmp_conta_lancada == null ? 'danger' : 'secondary' }} fas fa-user-times"></i></a>
                                                        </div>
                                                    </li>

                                                    <!-- Modal -->
                                                    <div class="modal fade"
                                                        id="modalInsumoCompraDel-{{ $insumo_compra->icmp_id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="labelModalInsumoCompraDel-{{ $insumo_compra->icmp_id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="labelModalInsumoCompraDel-{{ $insumo_compra->icmp_id }}">
                                                                        Remover Insumo da Compra</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Fechar">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Tem certeza que deseja remover o insumo dessa compra?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Fechar</button>
                                                                    <a href="{{ asset("/painel/insumo_compra/remover/$insumo_compra->icmp_id") }}"
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

                @if ($compra->cmp_conta_lancada == null)
                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3 d-flex justify-content-end">
                        <a href="{{ asset("/painel/contas_pagar/adicionar/$compra->cmp_id") }}"
                            class="btn btn-success"><em class="fas fa-receipt"></em> Lançar Conta a Pagar</a>
                    </div>
                @else
                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3 d-flex justify-content-end">
                        <form action='{{ asset('painel/contas_pagar/buscar') }}' method="POST">
                            @csrf
                            <input type="hidden" name="inputFiltro" value="{{ $compra->cmp_id }}">
                            <button type="submit" class="btn btn-success mr-1"><em class="fas fa-receipt"></em> Conta
                                lançada em: {{ date('d/m/Y H:i', strtotime($compra->cmp_conta_lancada)) }}</button>
                        </form>
                        <a class="btn btn-danger" data-toggle="modal" data-target="#modalCompra-{{ $compra->cmp_id }}"><i
                                class=" fas fa-user-times"></i>
                            Remover Conta Lançada</a>
                    </div>

                @endif

                <!-- Modal -->
                <div class="modal fade" id="modalCompra-{{ $compra->cmp_id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Remover Conta a Pagar</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Tem certeza que deseja remover a conta a pagar?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <a href="{{ asset("/painel/contas_pagar/remover/$compra->cmp_id") }}" type="button"
                                    class="btn btn-primary">Confirmar</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
