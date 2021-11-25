@extends('layout')

@section('conteudo')
    <div class="container">
        <div class="row">
            <div class="col col-12">

                <h1 class="text-center"><strong>Editar Conta a Pagar</strong></h1>

                <form action="{{ asset("painel/contas_pagar/editar/$conta->contp_id") }}" method="POST">
                    @csrf

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="valorContaPagar" class="form-label">Valor Parcela</label>
                        <input id="valorContaPagar" class="form-control" value="R$ {{ number_format($conta->contp_valor, 2, ',', '.') }}" readonly
                            required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="parcelaContaPagar" class="form-label">Numero Parcela</label>
                        <input id="parcelaContaPagar" class="form-control"
                            value="{{ $conta->contp_num_parcela . '/' . $conta->contp_total_parcelas }}" readonly
                            required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="emissaoContaPagar" class="form-label">Data Emissão</label>
                        <input type="date" id="emissaoContaPagar" class="form-control"
                            value="{{ date('Y-m-d', strtotime($conta->contp_data)) }}" disabled required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="vencimentoContaPagar" class="form-label">Data Vencimento</label>
                        <input type="date" id="vencimentoContaPagar" class="form-control"
                            value="{{ date('Y-m-d', strtotime($conta->contp_data_venc)) }}" disabled required>
                    </div>

                    @if ($conta->contp_data_pag != null)
                        <div class="row offset-1 offset-md-2 ">
                            <div class="col col-10 col-md-8 mt-3 mb-3">
                                <label for="pagamentoContaPagar" class="form-label">Data Pagamento</label>
                                <input type="date" id="pagamentoContaPagar" class="form-control" name="dataPagamento"
                                    value="{{ date('Y-m-d', strtotime($conta->contp_data_pag)) }}" disabled>
                            </div>
                            <div class="col col-1 col-md-1 mt-5">
                                <button type="button" class="btn btn-secondary"
                                    onclick='removerDisable("#pagamentoContaPagar")'>Alterar</button>
                            </div>
                        </div>
                    @else
                        <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                            <label for="pagamentoContaPagar" class="form-label">Data Recebimento</label>
                            <input type="date" id="pagamentoContaPagar" class="form-control" name="dataPagamento">
                        </div>
                    @endif

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="obsContaPagar" class="form-label">Observação</label>
                        <textarea name="observacao" id="obsContaPagar" rows="5" placeholder="Observação da Conta a Pagar"
                            class="form-control" maxlength="255">{{ $conta->contp_descricao }}</textarea>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                        <a href="{{ asset('painel/contas_pagar') }}" class="btn btn-secondary mr-1"><i
                                class="fas fa-times"></i>
                            Cancelar</a>
                        <a href="{{ asset("painel/compras/editar/$conta->tb_compras_cmp_id") }}"
                            class="btn btn-warning mr-1"><i class="fas fa-chevron-left"></i>
                            Revisar venda</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pen"></i> Editar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
