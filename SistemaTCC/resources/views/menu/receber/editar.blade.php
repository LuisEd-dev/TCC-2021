@extends('layout')

@section('conteudo')
    <div class="container">
        <div class="row">
            <div class="col col-12">

                <h1 class="text-center"><strong>Editar Conta a Receber</strong></h1>

                <form action="{{ asset("painel/contas_receber/editar/$conta->contr_id") }}" method="POST">
                    @csrf

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="valorContaReceber" class="form-label">Valor Parcela</label>
                        <input id="valorContaReceber" class="form-control" value="R$ {{ number_format($conta->contr_valor, 2, ',', '.') }}" readonly
                            required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="parcelaContaReceber" class="form-label">Numero Parcela</label>
                        <input id="parcelaContaReceber" class="form-control"
                            value="{{ $conta->contr_num_parcela . '/' . $conta->contr_total_parcelas }}" readonly
                            required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="emissaoContaReceber" class="form-label">Data Emissão</label>
                        <input type="date" id="emissaoContaReceber" class="form-control"
                            value="{{ date('Y-m-d', strtotime($conta->contr_data)) }}" disabled required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="vencimentoContaReceber" class="form-label">Data Vencimento</label>
                        <input type="date" id="vencimentoContaReceber" class="form-control"
                            value="{{ date('Y-m-d', strtotime($conta->contr_data_venc)) }}" disabled required>
                    </div>

                    @if ($conta->contr_data_rec != null)
                        <div class="row offset-1 offset-md-2 ">
                            <div class="col col-10 col-md-8 mt-3 mb-3">
                                <label for="pagamentoContaReceber" class="form-label">Data Recebimento</label>
                                <input type="date" id="pagamentoContaReceber" class="form-control" name="dataPagamento"
                                    value="{{ date('Y-m-d', strtotime($conta->contr_data_rec)) }}" disabled>
                            </div>
                            <div class="col col-1 col-md-1 mt-5">
                                <button type="button" class="btn btn-secondary"
                                    onclick='removerDisable("#pagamentoContaReceber")'>Alterar</button>
                            </div>
                        </div>
                    @else
                        <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                            <label for="pagamentoContaReceber" class="form-label">Data Recebimento</label>
                            <input type="date" id="pagamentoContaReceber" class="form-control" name="dataPagamento">
                        </div>
                    @endif

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="obsContaReceber" class="form-label">Observação</label>
                        <textarea name="observacao" id="obsContaReceber" rows="5"
                            placeholder="Observação da Conta a Receber"
                            class="form-control" maxlength="255">{{ $conta->contr_descricao }}</textarea>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                        <a href="{{ asset('painel/contas_receber') }}" class="btn btn-secondary mr-1"><i
                                class="fas fa-times"></i>
                            Cancelar</a>
                        <a href="{{ asset("painel/vendas/editar/$conta->tb_vendas_ven_id") }}"
                            class="btn btn-warning mr-1"><i class="fas fa-chevron-left"></i>
                            Revisar venda</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pen"></i> Editar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
