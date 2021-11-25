@extends('layout')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col col-12">

                <h1 class="text-center"><strong>Alterar Fornecedor</strong></h1>
                <form action="{{ asset("painel/fornecedores/editar/$fornecedor->for_id") }}" method="POST">
                    @csrf

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="nomeFornecedor" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nomeFornecedor" name="nome"
                            placeholder="Nome do Fornecedor" value="{{ $fornecedor->for_nome }}" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="pessoaFornecedor" class="form-label">Tipo Pessoa</label>
                        <select class="custom-select" id="ufFornecedor" name="tipoPessoa"
                            onchange='trocarTipoDoc("#documentoFornecedor", this.value)'>
                            <option value="PF" @if ($fornecedor->for_tipo_pessoa == 'PF') selected @endif>Pessoa Física</option>
                            <option value="PJ" @if ($fornecedor->for_tipo_pessoa == 'PJ') selected @endif>Pessoa Jurídica</option>
                        </select>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="documentoFornecedor" class="form-label">CPF / CNPJ</label>
                        <input type="text"
                            class="form-control {{ $fornecedor->for_tipo_pessoa == 'PF' ? 'cpf' : 'cnpj' }}"
                            id="documentoFornecedor" name="cpfCnpj" placeholder="CPF ou CNPJ do Fornecedor"
                            value="{{ $fornecedor->for_cpf_cnpj }}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="registroFornecedor" class="form-label">RG / IE</label>
                        <input type="number" class="form-control" id="registroFornecedor" name="rgIE"
                            placeholder="RG ou IE do Fornecedor" value="{{ $fornecedor->for_rg_ie }}"
                            onKeyPress="if(this.value.length==14) return false;"
                            onchange="if(this.value.length>14){this.value = ''}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="enderecoFornecedor" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="enderecoFornecedor" name="endereco"
                            placeholder="Endereço do Fornecedor" value="{{ $fornecedor->for_endereco }}" maxlength="255"
                            required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="numeroFornecedor" class="form-label">Número</label>
                        <input type="number" class="form-control" id="numeroFornecedor" name="numero"
                            placeholder="Número do Fornecedor" value="{{ $fornecedor->for_numero }}"
                            onKeyPress="if(this.value.length==10) return false;"
                            onchange="if(this.value.length>10){this.value = ''}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="bairroFornecedor" class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="bairroFornecedor" name="bairro"
                            placeholder="Bairro do Fornecedor" value="{{ $fornecedor->for_bairro }}" maxlength="255"
                            required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="cidadeFornecedor" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidadeFornecedor" name="cidade"
                            placeholder="Cidade do Fornecedor" value="{{ $fornecedor->for_cidade }}" maxlength="255"
                            required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="ufFornecedor" class="form-label">Estado</label>
                        <select class="custom-select" id="ufFornecedor" name="uf">
                            <option value="AC" @if ($fornecedor->for_uf == 'AC') selected @endif>Acre</option>
                            <option value="AL" @if ($fornecedor->for_uf == 'AL') selected @endif>Alagoas</option>
                            <option value="AP" @if ($fornecedor->for_uf == 'AP') selected @endif>Amapá</option>
                            <option value="AM" @if ($fornecedor->for_uf == 'AM') selected @endif>Amazonas</option>
                            <option value="BA" @if ($fornecedor->for_uf == 'BA') selected @endif>Bahia</option>
                            <option value="CE" @if ($fornecedor->for_uf == 'CE') selected @endif>Ceará</option>
                            <option value="DF" @if ($fornecedor->for_uf == 'DF') selected @endif>Distrito Federal</option>
                            <option value="ES" @if ($fornecedor->for_uf == 'ES') selected @endif>Espírito Santo</option>
                            <option value="GO" @if ($fornecedor->for_uf == 'GO') selected @endif>Goiás</option>
                            <option value="MA" @if ($fornecedor->for_uf == 'MA') selected @endif>Maranhão</option>
                            <option value="MT" @if ($fornecedor->for_uf == 'MT') selected @endif>Mato Grosso</option>
                            <option value="MS" @if ($fornecedor->for_uf == 'MS') selected @endif>Mato Grosso do Sul</option>
                            <option value="MG" @if ($fornecedor->for_uf == 'MG') selected @endif>Minas Gerais</option>
                            <option value="PA" @if ($fornecedor->for_uf == 'PA') selected @endif>Pará</option>
                            <option value="PB" @if ($fornecedor->for_uf == 'PB') selected @endif>Paraíba</option>
                            <option value="PR" @if ($fornecedor->for_uf == 'PR') selected @endif>Paraná</option>
                            <option value="PE" @if ($fornecedor->for_uf == 'PE') selected @endif>Pernambuco</option>
                            <option value="PI" @if ($fornecedor->for_uf == 'PI') selected @endif>Piauí</option>
                            <option value="RJ" @if ($fornecedor->for_uf == 'RJ') selected @endif>Rio de Janeiro</option>
                            <option value="RN" @if ($fornecedor->for_uf == 'RN') selected @endif>Rio Grande do Norte</option>
                            <option value="RS" @if ($fornecedor->for_uf == 'RS') selected @endif>Rio Grande do Sul</option>
                            <option value="RO" @if ($fornecedor->for_uf == 'RO') selected @endif>Rondônia</option>
                            <option value="RR" @if ($fornecedor->for_uf == 'RR') selected @endif>Roraima</option>
                            <option value="SC" @if ($fornecedor->for_uf == 'SC') selected @endif>Santa Catarina</option>
                            <option value="SP" @if ($fornecedor->for_uf == 'SP') selected @endif>São Paulo</option>
                            <option value="SE" @if ($fornecedor->for_uf == 'SE') selected @endif>Sergipe</option>
                            <option value="TO" @if ($fornecedor->for_uf == 'TO') selected @endif>Tocantins</option>
                        </select>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="cepFornecedor" class="form-label">CEP</label>
                        <input type="text" class="form-control cep" id="cepFornecedor" name="cep"
                            placeholder="CEP do Fornecedor" value="{{ $fornecedor->for_cep }}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="complementoFornecedor" class="form-label">Complemento</label>
                        <textarea type="text" class="form-control" id="complementoFornecedor" name="complemento"
                            placeholder="Complemento do Fornecedor"
                            maxlength="255">{{ $fornecedor->for_complemento }}</textarea>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="celularFornecedor" class="form-label">Celular</label>
                        <input type="tel" class="form-control celular" id="celularFornecedor" name="celular"
                            placeholder="Celular do Fornecedor" value="{{ $fornecedor->for_celular }}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="telefoneFornecedor" class="form-label">Telefone</label>
                        <input type="tel" class="form-control telefone" id="telefoneFornecedor" name="telefone"
                            placeholder="Telefone do Fornecedor" value="{{ $fornecedor->for_telefone }}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="emailFornecedor" class="form-label">Email</label>
                        <input type="email" class="form-control" id="emailFornecedor" name="email"
                            placeholder="Email do Fornecedor" value="{{ $fornecedor->for_email }}" maxlength="255"
                            required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                        <a href="{{ asset('painel/fornecedores') }}" class="btn btn-secondary mr-1"><i
                                class="fas fa-times"></i> Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pen"></i> Alterar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
