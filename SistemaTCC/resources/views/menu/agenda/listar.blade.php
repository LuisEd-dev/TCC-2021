@extends('layout')

@section('conteudo')

    <div class="container-fluid">
        <header>
            <div class="row mb-3">
                <div class="col col-sm-1 col-md d-flex align-items-center justify-content-md-end justify-content-start">
                    <h1>
                        <a href="?mes={{ date('Y-m', strtotime('-1 months', $mesAtual)) }}">
                            <i class="text-secondary fas fa-chevron-left"></i>
                        </a>
                    </h1>
                </div>
                <div class="col col-sm-2 col-md">
                    <h1 class="font-weight-light text-center">
                        {{ ucwords(utf8_encode(strftime('%B %Y', $mesAtual))) }}
                    </h1>
                </div>
                <div class="col col-sm-1 col-md d-flex align-items-center justify-content-md-start justify-content-end">
                    <h1>
                        <a href="?mes={{ date('Y-m', strtotime('+1 months', $mesAtual)) }}">
                            <i class="text-secondary fas fa-chevron-right"></i>
                        </a>
                    </h1>
                </div>
            </div>
            <div class="row d-none d-sm-flex p-1 bg-dark text-white">
                <h5 class="col-sm p-1 text-center">Domingo</h5>
                <h5 class="col-sm p-1 text-center">Segunda-feira</h5>
                <h5 class="col-sm p-1 text-center">Terça-feira</h5>
                <h5 class="col-sm p-1 text-center">Quarta-feira</h5>
                <h5 class="col-sm p-1 text-center">Quinta-feira</h5>
                <h5 class="col-sm p-1 text-center">Sexta-feira</h5>
                <h5 class="col-sm p-1 text-center">Sábado</h5>
            </div>
        </header>
        <div class="row border border-right-0 border-bottom-0">
            @for ($row = 1; $row <= 6; $row++)
                @for ($col = 1; $col <= 7; $col++)
                    @if ($dataInicio < $mesAtual || $dataInicio >= $mesSeguinte)
                        <div
                            class="day col-sm p-2 border border-left-0 border-top-0 text-truncate d-none d-sm-inline-block bg-light text-muted">
                            <h5 class="row align-items-center">
                                <span class="date col-1">{{ date('d', $dataInicio) }}</span>
                                <small
                                    class="col d-sm-none text-center text-muted">{{ ucwords(utf8_encode(strftime('%A', $dataInicio))) }}</small>
                                <span class="col-1"></span>
                            </h5>

                            @php
                                $agendasDia = $agendas->filter(function ($value, $key) use ($dataInicio) {
                                    return date('Y-m-d', strtotime($value->agd_data)) == date('Y-m-d', $dataInicio);
                                });
                            @endphp
                            @if ($agendasDia->count() > 0)
                                @foreach ($agendasDia as $agenda)
                                    <a class="event d-block p-1 pl-2 pr-2 mb-1 rounded text-truncate small bg-{{ $agenda->agd_cor }} text-white"
                                        data-toggle="modal"
                                        data-target="#modalAgenda-{{ $agenda->agd_id }}">{{ $agenda->agd_titulo }}</a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modalAgenda-{{ $agenda->agd_id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="modalAgendaLabel-{{ $agenda->agd_id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ asset("painel/agenda/editar/$agenda->agd_id") }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title ellipsis"
                                                            id="modalAgendaLabel-{{ $agenda->agd_id }}">
                                                            {{ $agenda->agd_titulo }}
                                                        </h5>
                                                        <input type="hidden" class="form-control"
                                                            id="tituloEvento-{{ $agenda->agd_id }}" name="titulo"
                                                            placeholder="Título do Evento"
                                                            value="{{ $agenda->agd_titulo }}" maxlength="255" required>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <textarea name="descricao" id="descricao-{{ $agenda->agd_id }}"
                                                            rows="5" placeholder="Descriçao do Evento"
                                                            class="form-control"
                                                            maxlength="255">{{ $agenda->agd_descricao }}</textarea>

                                                        <select hidden="true" class="custom-select mt-3"
                                                            id="corEvento-{{ $agenda->agd_id }}" name="cor"
                                                            onchange="document.getElementById('corEvento-{{ $agenda->agd_id }}').style = 'color:' +document.getElementById('corEvento-{{ $agenda->agd_id }}').options[document.getElementById('corEvento-{{ $agenda->agd_id }}').selectedIndex].dataset.hex">
                                                            <option value="primary" class="text-primary"
                                                                @if ($agenda->agd_cor == 'primary') selected @endif data-hex="#007bff">
                                                                Azul</option>
                                                            <option value="secondary" class="text-secondary"
                                                                @if ($agenda->agd_cor == 'secondary') selected @endif data-hex="#6c757d">
                                                                Cinza</option>
                                                            <option value="success" class="text-success"
                                                                @if ($agenda->agd_cor == 'success') selected @endif data-hex="#28a745">
                                                                Verde</option>
                                                            <option value="danger" class="text-danger"
                                                                @if ($agenda->agd_cor == 'danger') selected @endif data-hex="#dc3545">
                                                                Vermelho</option>
                                                            <option value="warning" class="text-warning"
                                                                @if ($agenda->agd_cor == 'warning') selected @endif data-hex="#ffc107">
                                                                Amarelo</option>
                                                            <option value="info" class="text-info"
                                                                @if ($agenda->agd_cor == 'info') selected @endif data-hex="#17a2b8">
                                                                Ciano
                                                            </option>
                                                        </select>

                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <a onclick='confirmarRemoverAgenda(this, "{{ asset("painel/agenda/remover/$agenda->agd_id") }}", event, "modalAgenda-{{ $agenda->agd_id }}")'
                                                            type="button" class="btn btn-danger">Remover</a>
                                                        <div>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Fechar</button>
                                                            <button type="button" class="btn btn-primary"
                                                                onclick='alterarAgenda(this, "modalAgenda-{{ $agenda->agd_id }}", document.getElementById("modalAgendaLabel-{{ $agenda->agd_id }}"), document.getElementById("tituloEvento-{{ $agenda->agd_id }}"), document.getElementById("corEvento-{{ $agenda->agd_id }}"), event)'><i
                                                                    class="fas fa-pen"></i> Alterar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="d-sm-none">Nenhum Evento</p>
                            @endif
                        </div>
                    @else
                        <div class="day col-sm p-2 border border-left-0 border-top-0 text-truncate">
                            <h5 class="row align-items-center">
                                <a class="date col-1 text-decoration-none text-dark"
                                    href="{{ asset('painel/agenda/adicionar?data=' . date('Y-m-d', $dataInicio)) }}">{{ date('d', $dataInicio) }}</a>
                                <small
                                    class="col d-sm-none text-center text-muted">{{ ucwords(utf8_encode(strftime('%A', $dataInicio))) }}</small>
                                <span class="col-1"></span>
                            </h5>
                            @php
                                $agendasDia = $agendas->filter(function ($value, $key) use ($dataInicio) {
                                    return date('Y-m-d', strtotime($value->agd_data)) == date('Y-m-d', $dataInicio);
                                });
                            @endphp
                            @if ($agendasDia->count() > 0)
                                @foreach ($agendasDia as $agenda)
                                    <a class="event d-block p-1 pl-2 pr-2 mb-1 rounded text-truncate small bg-{{ $agenda->agd_cor }} text-white"
                                        data-toggle="modal"
                                        data-target="#modalAgenda-{{ $agenda->agd_id }}">{{ $agenda->agd_titulo }}</a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modalAgenda-{{ $agenda->agd_id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="modalAgendaLabel-{{ $agenda->agd_id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ asset("painel/agenda/editar/$agenda->agd_id") }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title ellipsis"
                                                            id="modalAgendaLabel-{{ $agenda->agd_id }}">
                                                            {{ $agenda->agd_titulo }}
                                                        </h5>
                                                        <input type="hidden" class="form-control"
                                                            id="tituloEvento-{{ $agenda->agd_id }}" name="titulo"
                                                            placeholder="Título do Evento"
                                                            value="{{ $agenda->agd_titulo }}" maxlength="255" required>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <textarea name="descricao" id="descricao-{{ $agenda->agd_id }}"
                                                            rows="5" placeholder="Descriçao do Evento"
                                                            class="form-control"
                                                            maxlength="255">{{ $agenda->agd_descricao }}</textarea>

                                                        <select hidden="true" class="custom-select mt-3"
                                                            id="corEvento-{{ $agenda->agd_id }}" name="cor"
                                                            onchange="document.getElementById('corEvento-{{ $agenda->agd_id }}').style = 'color:' +document.getElementById('corEvento-{{ $agenda->agd_id }}').options[document.getElementById('corEvento-{{ $agenda->agd_id }}').selectedIndex].dataset.hex">
                                                            <option value="primary" class="text-primary"
                                                                @if ($agenda->agd_cor == 'primary') selected @endif data-hex="#007bff">
                                                                Azul</option>
                                                            <option value="secondary" class="text-secondary"
                                                                @if ($agenda->agd_cor == 'secondary') selected @endif data-hex="#6c757d">
                                                                Cinza</option>
                                                            <option value="success" class="text-success"
                                                                @if ($agenda->agd_cor == 'success') selected @endif data-hex="#28a745">
                                                                Verde</option>
                                                            <option value="danger" class="text-danger"
                                                                @if ($agenda->agd_cor == 'danger') selected @endif data-hex="#dc3545">
                                                                Vermelho</option>
                                                            <option value="warning" class="text-warning"
                                                                @if ($agenda->agd_cor == 'warning') selected @endif data-hex="#ffc107">
                                                                Amarelo</option>
                                                            <option value="info" class="text-info"
                                                                @if ($agenda->agd_cor == 'info') selected @endif data-hex="#17a2b8">
                                                                Ciano
                                                            </option>
                                                        </select>

                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <a onclick='confirmarRemoverAgenda(this, "{{ asset("painel/agenda/remover/$agenda->agd_id") }}", event, "modalAgenda-{{ $agenda->agd_id }}")'
                                                            type="button" class="btn btn-danger">Remover</a>
                                                        <div>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Fechar</button>
                                                            <button type="button" class="btn btn-primary"
                                                                onclick='alterarAgenda(this, "modalAgenda-{{ $agenda->agd_id }}",document.getElementById("modalAgendaLabel-{{ $agenda->agd_id }}"), document.getElementById("tituloEvento-{{ $agenda->agd_id }}"), document.getElementById("corEvento-{{ $agenda->agd_id }}"), event)'><i
                                                                    class="fas fa-pen"></i> Alterar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            @else
                                <p class="d-sm-none">Nenhum Evento</p>
                            @endif
                        </div>
                    @endif
                    @php
                        $dataInicio = strtotime('+1 day', $dataInicio);
                    @endphp
                @endfor
                <div class="w-100"></div>
            @endfor
        </div>
    </div>
@endsection
