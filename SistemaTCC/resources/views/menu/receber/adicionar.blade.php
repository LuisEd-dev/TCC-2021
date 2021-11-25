@extends('layout')

@section('conteudo')

    @php
    date_default_timezone_set('America/Sao_Paulo');
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    @endphp

    <div class="container">
        <div class="row">
            <div class="col col-12">

                <h1 class="text-center"><strong>Lançar Conta a Receber</strong></h1>

                <form action="{{ asset('painel/contas_receber/adicionar') }}" method="POST">
                    @csrf

                    @php
                        $total = 0;
                        foreach ($venda->produtos_venda as $produto) {
                            $total = $total + ($produto->iven_venda * $produto->iven_quantidade);
                        }
                    @endphp

                    <input name="cliente" id="clienteContaReceber" class="form-control" value="{{ $cliente->cli_id }}"
                        required hidden>
                    <input name="venda" id="vendaContaReceber" class="form-control" value="{{ $venda->ven_id }}"
                        required hidden>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="totalContaReceber" class="form-label">Total</label>
                        <input name="total" id="totalContaReceber" class="form-control" value="R$ {{ number_format($total, 2, ',', '.') }}"
                            readonly required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="dataContaReceber" class="form-label">Data Emissão</label>
                        <input id="dataContaReceber" class="form-control" value="{{ date(' d/m/Y') }}" disabled
                            required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="dataCobranca" class="form-label">Primeira Cobrança</label>
                        <input type="date" id="dataCobranca" class="form-control"
                            value="{{ date('Y-m-d', strtotime(date('Y-m-d') . ' + 1 months')) }}" name="cobranca"
                            required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="parcelasContaReceber" class="form-label">Parcelas</label>
                        <input name="parcelas" id="parcelasContaReceber" class="form-control" value="1" type="number"
                            min="1" max="12" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="obsContaReceber" class="form-label">Observação</label>
                        <textarea name="observacao" id="obsContaReceber" rows="5"
                            placeholder="Observação da Conta a Receber" class="form-control" maxlength="255"></textarea>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                        <a href="{{ asset('painel/contas_receber') }}" class="btn btn-secondary mr-1"><i
                                class="fas fa-times"></i>
                            Cancelar</a>
                        <a href="{{ URL::previous() }}" class="btn btn-warning mr-1"><i class="fas fa-chevron-left"></i>
                            Revisar</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Lançar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
