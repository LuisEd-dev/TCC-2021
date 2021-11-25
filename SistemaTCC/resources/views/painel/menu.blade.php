@extends('layout')

@section('conteudo')

    @php
    date_default_timezone_set('America/Sao_Paulo');
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="row">

                    <div class="col col-12 col-md-6">
                        <div class="card border border-secondary">
                            <div class="card-body">
                                <h1 class="mt-3 card-title text-center">{{ $contas_receber->count() }}
                                </h1>
                                <h4 class="mt-3 card-subtitle mb-2 text-center text-muted">Contas a Receber</h4>
                                <div class="mt-3 d-flex justify-content-between">

                                    @php
                                        $valorReceberPagas =
                                            0 +
                                            $contas_receber->whereNotNull('contr_data_rec')->reduce(function ($carry, $item) {
                                                return $carry + $item->contr_valor;
                                            });

                                        $valorReceberPendentes =
                                            0 +
                                            $contas_receber->whereNull('contr_data_rec')->reduce(function ($carry, $item) {
                                                return $carry + $item->contr_valor;
                                            });
                                    @endphp

                                    <h6 type="button" class="badge badge-success" data-toggle="popover" data-placement="top"
                                        data-content="R$ {{ number_format($valorReceberPagas, 2, ',', '.') }}">
                                        {{ $contas_receber->whereNotNull('contr_data_rec')->count() }}
                                        Pagas</h6>
                                    <h6 type="button" class="badge badge-warning" data-toggle="popover" data-placement="top"
                                        data-content="R$ {{ number_format($valorReceberPendentes, 2, ',', '.') }}">
                                        {{ $contas_receber->whereNull('contr_data_rec')->count() }}
                                        Pendentes</h6>
                                </div>
                                <div class="mt-3 progress">
                                    @if ($contas_receber->count() > 0)
                                        @php
                                            $contasReceberPagas = ($contas_receber->whereNotNull('contr_data_rec')->count() / $contas_receber->count()) * 100;
                                            $contasReceberPendentes = ($contas_receber->whereNull('contr_data_rec')->count() / $contas_receber->count()) * 100;
                                        @endphp
                                    @else
                                        @php
                                            $contasReceberPagas = ($contas_receber->whereNotNull('contr_data_rec')->count() / 1) * 100;
                                            $contasReceberPendentes = ($contas_receber->whereNull('contr_data_rec')->count() / 1) * 100;
                                        @endphp
                                    @endif
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ $contasReceberPagas }}%" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-warning" role="progressbar"
                                        style="width: {{ $contasReceberPendentes }}%" aria-valuemax="100"></div>
                                </div>
                                <h3 class="mt-3 text-center"><a href="{{ asset('painel/contas_receber') }}"
                                        class="card-link">Gerenciar</a></h3>
                            </div>
                        </div>
                    </div>

                    <div class="col col-12 col-md-6 mt-3 mt-md-0">
                        <div class="card border border-secondary">
                            <div class="card-body">
                                <h1 class="mt-3 card-title text-center">{{ $contas_pagar->count() }}
                                </h1>
                                <h4 class="mt-3 card-subtitle mb-2 text-center text-muted">Contas a Pagar</h4>
                                <div class="mt-3 d-flex justify-content-between">

                                    @php
                                        $valorPagarPagas =
                                            0 +
                                            $contas_pagar->whereNotNull('contp_data_pag')->reduce(function ($carry, $item) {
                                                return $carry + $item->contp_valor;
                                            });

                                        $valorPagarPendentes =
                                            0 +
                                            $contas_pagar->whereNull('contp_data_pag')->reduce(function ($carry, $item) {
                                                return $carry + $item->contp_valor;
                                            });
                                    @endphp

                                    <h6 type="button" class="badge badge-success" data-toggle="popover" data-placement="top"
                                        data-content="R$ {{ number_format($valorPagarPagas, 2, ',', '.') }}">
                                        {{ $contas_pagar->whereNotNull('contp_data_pag')->count() }}
                                        Pagas </h6>
                                    <h6 class="badge badge-warning" data-toggle="popover" data-placement="top"
                                        data-content="R$ {{ number_format($valorPagarPendentes, 2, ',', '.') }}">
                                        {{ $contas_pagar->whereNull('contp_data_pag')->count() }}
                                        Pendentes</h6>
                                </div>
                                <div class="mt-3 progress">
                                    @if ($contas_pagar->count() > 0)
                                        @php
                                            $contasPagarPagas = ($contas_pagar->whereNotNull('contp_data_pag')->count() / $contas_pagar->count()) * 100;
                                            $contasPagarPendentes = ($contas_pagar->whereNull('contp_data_pag')->count() / $contas_pagar->count()) * 100;
                                        @endphp
                                    @else
                                        @php
                                            $contasPagarPagas = ($contas_pagar->whereNotNull('contp_data_pag')->count() / 1) * 100;
                                            $contasPagarPendentes = ($contas_pagar->whereNull('contp_data_pag')->count() / 1) * 100;
                                        @endphp
                                    @endif
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ $contasPagarPagas }}%" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-warning" role="progressbar"
                                        style="width: {{ $contasPagarPendentes }}%" aria-valuemax="100"></div>
                                </div>
                                <h3 class="mt-3 text-center"><a href="{{ asset('painel/contas_pagar') }}"
                                        class="card-link">Gerenciar</a></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col col-12 col-md-4 mt-3 mt-md-0">
                <div class="card border border-secondary" style="height: 100%;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col col-1 d-flex align-items-center">
                                <h1 class="align-items-center">
                                    <a href="?mes={{ date('Y-m', strtotime('-1 months', strtotime($data))) }}">
                                        <i class="text-secondary fas fa-chevron-left"></i>
                                    </a>
                                </h1>
                            </div>

                            <div class="col col-10">
                                <h1 class="mt-3 card-title text-center">Caixa
                                    ({{ ucwords(utf8_encode(strftime('%B', strtotime($data)))) }})</h1>
                            </div>

                            <div class="col col-1 d-flex align-items-center justify-content-end">
                                <h1>
                                    <a href="?mes={{ date('Y-m', strtotime('+1 months', strtotime($data))) }}">
                                        <i class="text-secondary fas fa-chevron-right"></i>
                                    </a>
                                </h1>
                            </div>
                        </div>

                        <div class="mt-3">
                            @php
                                $receberMes =
                                    0 +
                                    $caixaReceber->reduce(function ($carry, $item) {
                                        return $carry + $item->contr_valor;
                                    });
                                $pagarMes =
                                    0 +
                                    $caixaPagar->reduce(function ($carry, $item) {
                                        return $carry + $item->contp_valor;
                                    });
                            @endphp
                            <div class="d-flex justify-content-between">
                                <h5>Valor a receber/recebido:</h5>
                                <h5>R$ {{ number_format($receberMes, 2, ',', '.') }}</h5>
                            </div>
                            <div class="mt-3 d-flex justify-content-between">
                                <h5>Valor a pagar/pago: </h5>
                                <h5>R$ {{ number_format($pagarMes, 2, ',', '.') }}</h5>
                            </div>
                            <div class="mt-3 d-flex justify-content-center">
                                <h4>Saldo: R$ {{ number_format($receberMes - $pagarMes, 2, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">

            <div class="col col-12 col-md-5">
                <div class="card border border-secondary" style="height: 100%;">
                    <div class="card-body">
                        <h1 class="mt-3 card-title text-center">{{ $vendas->count() }}</h1>
                        <h4 class="mt-3 card-subtitle mb-2 text-center text-muted">Vendas</h4>
                        <div class="mt-3 d-flex justify-content-between">
                            <h6 class="badge badge-primary">{{ $vendas->whereNotNull('ven_conta_lancada')->count() }}
                                Conta
                                lançada</h6>
                            <h6 class="badge badge-secondary">{{ $vendas->whereNull('ven_conta_lancada')->count() }}
                                Conta
                                não
                                lançada</h6>
                        </div>
                        <div class="mt-3 progress">
                            @if ($vendas->count() > 0)
                                @php
                                    $vendasLancadas = ($vendas->whereNotNull('ven_conta_lancada')->count() / $vendas->count()) * 100;
                                    $vendaNaoLancadas = ($vendas->whereNull('ven_conta_lancada')->count() / $vendas->count()) * 100;
                                @endphp
                            @else
                                @php
                                    $vendasLancadas = ($vendas->whereNotNull('ven_conta_lancada')->count() / 1) * 100;
                                    $vendaNaoLancadas = ($vendas->whereNull('ven_conta_lancada')->count() / 1) * 100;
                                @endphp
                            @endif
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $vendasLancadas }}%"
                                aria-valuemax="100"></div>
                            <div class="progress-bar bg-secondary" role="progressbar"
                                style="width: {{ $vendaNaoLancadas }}%" aria-valuemax="100"></div>
                        </div>
                        <h3 class="mt-3 text-center"><a href="{{ asset('painel/vendas') }}"
                                class="card-link">Gerenciar</a>
                        </h3>

                    </div>
                </div>
            </div>

            <div class="col col-12 col-md-5 mt-3 mt-md-0">
                <div class="card border border-secondary" style="width: 100%;">
                    <div class="card-body">
                        <h1 class="mt-3 card-title text-center">{{ $compras->count() }}</h1>
                        <h4 class="mt-3 card-subtitle mb-2 text-center text-muted">Compras</h4>
                        <div class="mt-3 d-flex justify-content-between">
                            <h6 class="badge badge-primary">{{ $compras->whereNotNull('cmp_conta_lancada')->count() }}
                                Conta
                                lançada</h6>
                            <h6 class="badge badge-secondary">{{ $compras->whereNull('cmp_conta_lancada')->count() }}
                                Conta
                                não lançada</h6>
                        </div>
                        <div class="mt-3 progress">
                            @if ($compras->count() > 0)
                                @php
                                    $comprasLancadas = ($compras->whereNotNull('cmp_conta_lancada')->count() / $compras->count()) * 100;
                                    $comprasNaoLancadas = ($compras->whereNull('cmp_conta_lancada')->count() / $compras->count()) * 100;
                                @endphp
                            @else
                                @php
                                    $comprasLancadas = ($compras->whereNotNull('cmp_conta_lancada')->count() / 1) * 100;
                                    $comprasNaoLancadas = ($compras->whereNull('cmp_conta_lancada')->count() / 1) * 100;
                                @endphp
                            @endif
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ $comprasLancadas }}%" aria-valuemax="100"></div>
                            <div class="progress-bar bg-secondary" role="progressbar"
                                style="width: {{ $comprasNaoLancadas }}%" aria-valuemax="100"></div>
                        </div>
                        <h3 class="mt-3 text-center"><a href="{{ asset('painel/compras') }}"
                                class="card-link">Gerenciar</a></h3>
                    </div>
                </div>
            </div>

            <div class="col col-12 col-md-2 mt-3 mt-md-0">
                <div class="card border border-secondary h-100">
                    <div class="card-body d-flex align-items-center">

                        @php
                            $vendasHoje = $vendas->whereBetween('ven_data', [date('Y-m-d'), date('Y-m-d H:i:s')]);
                            $comprasHoje = $compras->whereBetween('cmp_data', [date('Y-m-d'), date('Y-m-d H:i:s')]);
                        @endphp

                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title mb-2 text-center ">Vendas Hoje:
                                    {{ $vendasHoje->count() }}
                                </h4>
                            </div>
                            <div class="col-12">
                                <h4 class="card-title mb-2 text-center ">Compras Hoje:
                                    {{ $comprasHoje->count() }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
