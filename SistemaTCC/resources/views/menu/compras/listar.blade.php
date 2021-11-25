@extends('layout')

@section('conteudo')

    @php
    date_default_timezone_set('America/Sao_Paulo');
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    @endphp

    <div class="container">

        <form action="{{ asset('painel/compras/buscar') }}" method="POST">
            @csrf
            <div class="form-group row">
                <label for="inputFiltro" class="col-sm-1 col-form-label">Filtro:</label>
                <div class="col-sm-9">
                    <input value="{{ $request->inputFiltro }}" type="text" class="form-control" id="inputFiltro"
                        name="inputFiltro" placeholder="ID Compra/Nome do Fornecedor/Observação">
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

        <div class="row d-flex flex-row-reverse">
            <a href="{{ asset('painel/compras/adicionar') }}" class="btn btn-success"><i class="fas fa-user-plus"></i>
                Adicionar</a>
        </div>

        <h3 class="text-center mb-3">Compras:</h3>

        <ul class="list-group">

            <li class="list-group-item d-flex align-items-center">
                <div class="col col-3 text-center font-weight-bold ellipsis">
                    <span>ID Compra</span>
                </div>
                <div class="col col-3 text-center font-weight-bold ellipsis">
                    <span>Fornecedor</span>
                </div>
                <div class="col col-3 text-center font-weight-bold ellipsis">
                    <span>Data</span>
                </div>
                <div class="col col-3 text-center font-weight-bold ellipsis">
                    <span>Opções</span>
                </div>
            </li>

            @foreach ($compras as $compra)
                <li class="list-group-item d-flex align-items-center">
                    <div class="col col-3 text-center ellipsis">
                        <span>{{ $compra->cmp_id }}</span>
                    </div>
                    <div class="col col-3 text-center ellipsis">
                        <span>{{ $compra->fornecedor->for_nome }}</span>
                    </div>
                    <div class="col col-3 text-center ellipsis">
                        <span>{{ date('d/m/Y H:i', strtotime($compra->cmp_data)) }}</span>
                    </div>
                    <div class="col col-3 text-center">
                        <div style="word-spacing: 10px">
                            <a href="{{ asset("/painel/compras/editar/$compra->cmp_id") }}"><i
                                    class="text-warning fas fa-user-edit"></i></a>
                            <a href="#" data-toggle="modal" data-target="#modalCompra-{{ $compra->cmp_id }}"><i
                                    class="text-danger fas fa-user-times"></i></a>
                        </div>
                    </div>
                </li>
                <!-- Modal -->
                <div class="modal fade" id="modalCompra-{{ $compra->cmp_id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Remover Compra</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Tem certeza que deseja remover a compra?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <a href="{{ asset("/painel/compras/remover/$compra->cmp_id") }}" type="button"
                                    class="btn btn-primary">Confirmar</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>

    </div>


@endsection
