@extends('layout')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col col-12">

                <h1 class="text-center"><strong>Alterar Cliente</strong></h1>
                <form action="{{ asset("painel/clientes/editar/$cliente->cli_id") }}" method="POST">
                    @csrf

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="nomeCliente" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nomeCliente" name="nome" placeholder="Nome do Cliente"
                            value="{{ $cliente->cli_nome }}" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="pessoaCliente" class="form-label">Tipo Pessoa</label>
                        <select class="custom-select" id="ufCliente" name="tipoPessoa"
                            onchange='trocarTipoDoc("#documentoCliente", this.value)'>
                            <option value="PF" @if ($cliente->cli_tipo_pessoa == 'PF') selected @endif>Pessoa Física</option>
                            <option value="PJ" @if ($cliente->cli_tipo_pessoa == 'PJ') selected @endif>Pessoa Jurídica</option>
                        </select>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="documentoCliente" class="form-label">CPF / CNPJ</label>
                        <input type="text" class="form-control {{ $cliente->cli_tipo_pessoa == 'PF' ? 'cpf' : 'cnpj' }}"
                            id="documentoCliente" name="cpfCnpj" placeholder="CPF ou CNPJ do Cliente"
                            value="{{ $cliente->cli_cpf_cnpj }}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="registroCliente" class="form-label">RG / IE</label>
                        <input type="numer" class="form-control" id="registroCliente" name="rgIE"
                            placeholder="RG ou IE do Cliente" value="{{ $cliente->cli_rg_ie }}"
                            onKeyPress="if(this.value.length==14) return false;"
                            onchange="if(this.value.length>14){this.value = ''}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="enderecoCliente" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="enderecoCliente" name="endereco"
                            placeholder="Endereço do Cliente" value="{{ $cliente->cli_endereco }}" maxlength="255"
                            required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="numeroCliente" class="form-label">Número</label>
                        <input type="number" class="form-control" id="numeroCliente" name="numero"
                            placeholder="Número do Cliente" value="{{ $cliente->cli_numero }}"
                            onKeyPress="if(this.value.length==10) return false;"
                            onchange="if(this.value.length>10){this.value = ''}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="bairroCliente" class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="bairroCliente" name="bairro"
                            placeholder="Bairro do Cliente" value="{{ $cliente->cli_bairro }}" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="cidadeCliente" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidadeCliente" name="cidade"
                            placeholder="Cidade do Cliente" value="{{ $cliente->cli_cidade }}" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="ufCliente" class="form-label">Estado</label>
                        <select class="custom-select" id="ufCliente" name="uf">
                            <option value="AC" @if ($cliente->cli_uf == 'AC') selected @endif>Acre</option>
                            <option value="AL" @if ($cliente->cli_uf == 'AL') selected @endif>Alagoas</option>
                            <option value="AP" @if ($cliente->cli_uf == 'AP') selected @endif>Amapá</option>
                            <option value="AM" @if ($cliente->cli_uf == 'AM') selected @endif>Amazonas</option>
                            <option value="BA" @if ($cliente->cli_uf == 'BA') selected @endif>Bahia</option>
                            <option value="CE" @if ($cliente->cli_uf == 'CE') selected @endif>Ceará</option>
                            <option value="DF" @if ($cliente->cli_uf == 'DF') selected @endif>Distrito Federal</option>
                            <option value="ES" @if ($cliente->cli_uf == 'ES') selected @endif>Espírito Santo</option>
                            <option value="GO" @if ($cliente->cli_uf == 'GO') selected @endif>Goiás</option>
                            <option value="MA" @if ($cliente->cli_uf == 'MA') selected @endif>Maranhão</option>
                            <option value="MT" @if ($cliente->cli_uf == 'MT') selected @endif>Mato Grosso</option>
                            <option value="MS" @if ($cliente->cli_uf == 'MS') selected @endif>Mato Grosso do Sul</option>
                            <option value="MG" @if ($cliente->cli_uf == 'MG') selected @endif>Minas Gerais</option>
                            <option value="PA" @if ($cliente->cli_uf == 'PA') selected @endif>Pará</option>
                            <option value="PB" @if ($cliente->cli_uf == 'PB') selected @endif>Paraíba</option>
                            <option value="PR" @if ($cliente->cli_uf == 'PR') selected @endif>Paraná</option>
                            <option value="PE" @if ($cliente->cli_uf == 'PE') selected @endif>Pernambuco</option>
                            <option value="PI" @if ($cliente->cli_uf == 'PI') selected @endif>Piauí</option>
                            <option value="RJ" @if ($cliente->cli_uf == 'RJ') selected @endif>Rio de Janeiro</option>
                            <option value="RN" @if ($cliente->cli_uf == 'RN') selected @endif>Rio Grande do Norte</option>
                            <option value="RS" @if ($cliente->cli_uf == 'RS') selected @endif>Rio Grande do Sul</option>
                            <option value="RO" @if ($cliente->cli_uf == 'RO') selected @endif>Rondônia</option>
                            <option value="RR" @if ($cliente->cli_uf == 'RR') selected @endif>Roraima</option>
                            <option value="SC" @if ($cliente->cli_uf == 'SC') selected @endif>Santa Catarina</option>
                            <option value="SP" @if ($cliente->cli_uf == 'SP') selected @endif>São Paulo</option>
                            <option value="SE" @if ($cliente->cli_uf == 'SE') selected @endif>Sergipe</option>
                            <option value="TO" @if ($cliente->cli_uf == 'TO') selected @endif>Tocantins</option>
                        </select>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="cepCliente" class="form-label">CEP</label>
                        <input type="text" class="form-control cep" id="cepCliente" name="cep" placeholder="CEP do Cliente"
                            value="{{ $cliente->cli_cep }}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="complementoCliente" class="form-label">Complemento</label>
                        <textarea type="text" class="form-control" id="complementoCliente" name="complemento"
                            placeholder="Complemento do Cliente"
                            maxlength="255">{{ $cliente->cli_complemento }}</textarea>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="celularCliente" class="form-label">Celular</label>
                        <input type="tel" class="form-control celular" id="celularCliente" name="celular"
                            placeholder="Celular do Cliente" value="{{ $cliente->cli_celular }}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="telefoneCliente" class="form-label">Telefone</label>
                        <input type="tel" class="form-control telefone" id="telefoneCliente" name="telefone"
                            placeholder="Telefone do Cliente" value="{{ $cliente->cli_telefone }}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="emailCliente" class="form-label">Email</label>
                        <input type="email" class="form-control" id="emailCliente" name="email"
                            placeholder="Email do Cliente" value="{{ $cliente->cli_email }}" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                        <a href="{{ asset('painel/clientes') }}" class="btn btn-secondary mr-1"><i
                                class="fas fa-times"></i> Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pen"></i> Alterar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
