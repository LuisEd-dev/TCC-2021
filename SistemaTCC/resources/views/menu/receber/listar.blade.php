@extends('layout')

@section('conteudo')

    @php
    date_default_timezone_set('America/Sao_Paulo');
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    @endphp

    <div class="container">

        <form action="{{ asset('painel/contas_receber/buscar') }}" method="POST">
            @csrf
            <div class="form-group row">
                <label for="inputFiltro" class="col-sm-1 col-form-label">Filtro:</label>
                <div class="col-sm-7">
                    <input value="{{ $request->inputFiltro }}" type="text" class="form-control" id="inputFiltro"
                        name="inputFiltro" placeholder="ID do venda/Cliente">
                </div>
                <div class="col-sm-2">
                    <div class="form-check my-1">
                        <input class="form-check-input" id="flexCheckDefault" type="checkbox" name="checkPagos"
                            {{ isset($check) && $check == 'on' ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexCheckDefault">
                            Exibir pagos
                        </label>
                    </div>
                </div>
                <button class="btn btn-primary col-sm-1" type="submit">Buscar</button>
                <button class="btn btn-secondary col-sm-1" onclick="document.querySelector('#inputFiltro').value = ''"
                    type="submit">Limpar</button>
            </div>
            <div class="form-group row d-flex justify-content-end">
                <label for="filtroData" class="col-sm-1 col-form-label">Período:</label>
                <input type="date" id="filtroDataInicio" name="filtroDataInicio" class="mr-3"
                    value="{{ isset($filtroDataInicio) && $filtroDataInicio != null ? $filtroDataInicio : date('Y-m-d') }}">
                <input type="date" id="filtroDataFim" name="filtroDataFim" class="mr-3"
                    value="{{ isset($filtroDataFim) && $filtroDataFim != null ? $filtroDataFim : null }}">
            </div>
        </form>

        <h3 class="text-center mb-3">Contas a Receber:</h3>

        <div class="accordion" id="accordionExample">
            @foreach ($contasPorVenda as $key => $value)
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <div class="d-flex justify-content-between">
                            <h5>ID venda : {{ $key }} | Total: R$
                                {{ number_format(
                                    $value->reduce(function ($carry, $item) {
                                        return $carry + $item->contr_valor;
                                    }),
                                    2,
                                    ',',
                                    '.',
                                ) }}
                            </h5>
                            <button onclick='collapseIconChange(this, "icon-{{ $key }}")' class="btn btn-light"
                                type="button" data-toggle="collapse" data-target="#collapseOne-{{ $key }}"
                                aria-expanded="false" aria-controls="collapseOne">
                                <i id="icon-{{ $key }}" class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>

                    <div id="collapseOne-{{ $key }}" class="collapse" aria-labelledby="headingOne"
                        data-parent="#accordionExample">
                        <ul class="list-group">

                            <li class="list-group-item d-flex align-items-center">
                                <div class="col col-2 text-center font-weight-bold ellipsis">
                                    <span>Data Emissão</span>
                                </div>
                                <div class="col col-2 text-center font-weight-bold ellipsis">
                                    <span>Data Vencimento</span>
                                </div>
                                <div class="col col-2 text-center font-weight-bold ellipsis">
                                    <span>Parcelas</span>
                                </div>
                                <div class="col col-2 text-center font-weight-bold ellipsis">
                                    <span>Valor Parcela</span>
                                </div>
                                <div class="col col-2 text-center font-weight-bold ellipsis">
                                    <span>Status</span>
                                </div>
                                <div class="col col-2 text-center font-weight-bold ellipsis">
                                    <span>Opções</span>
                                </div>
                            </li>

                            @foreach ($value as $conta)
                                <li class="list-group-item d-flex align-items-center">
                                    <div class="col col-2 text-center">
                                        <span>{{ date('d/m/Y H:i', strtotime($conta->contr_data)) }}</span>
                                    </div>
                                    <div class="col col-2 text-center">
                                        <span>{{ date('d/m/Y', strtotime($conta->contr_data_venc)) }}</span>
                                    </div>
                                    <div class="col col-2 text-center">
                                        <span
                                            class="badge badge-pill badge-secondary">{{ $conta->contr_num_parcela }}/{{ $conta->contr_total_parcelas }}</span>
                                    </div>
                                    <div class="col col-2 text-center">
                                        <span>R$ {{ number_format($conta->contr_valor, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="col col-2 text-center">
                                        @php
                                            if ($conta->contr_data_rec != null) {
                                                $status = 'Pago';
                                                $corStatus = 'success';
                                            } elseif (strtotime($conta->contr_data_venc) < strtotime(date('Y-m-d 00:00:00'))) {
                                                $status = 'Vencida';
                                                $corStatus = 'danger';
                                            } else {
                                                $status = 'Pendente';
                                                $corStatus = 'warning';
                                            }
                                        @endphp
                                        <span
                                            class="badge badge-pill badge-{{ $corStatus }}">{{ $status }}</span>
                                    </div>
                                    <div class="col col-2 text-center">
                                        <div style="word-spacing: 10px">
                                            <a href="#" data-toggle="modal"
                                                data-target="#modalContaReceber-{{ $conta->contr_id }}"
                                                @if ($conta->contr_data_rec != null) style="pointer-events: none;" @endif><i
                                                    class="text-{{ $conta->contr_data_rec == null ? 'success' : 'secondary' }} fas fa-money-bill-alt"></i></a>
                                            <a href="{{ asset("/painel/contas_receber/editar/$conta->contr_id") }}"><i
                                                    class="text-warning fas fa-user-edit"></i></a>
                                        </div>
                                    </div>
                                </li>

                                <!-- Modal -->
                                <div class="modal fade" id="modalContaReceber-{{ $conta->contr_id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Alterar Conta</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Fechar">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Deseja marcar conta como paga no dia de hoje?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Fechar</button>
                                                <a href="{{ asset("/painel/contas_receber/quitar/$conta->contr_id") }}"
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
    </div>

@endsection
