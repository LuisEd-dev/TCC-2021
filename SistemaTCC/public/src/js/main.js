function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

function atualizaTotal(selectProduto, inputQtde, inputTotal) {
    inputTotal.value =
        (selectProduto.options[selectProduto.selectedIndex].dataset.precoVenda * inputQtde.value).toLocaleString('pt-br', {
            style: 'currency',
            currency: 'BRL'
        });
}

function showModal() {
    $('#modalLGPD').modal('show');
}

function removerDisable(id) {
    document.querySelector(id).removeAttribute("disabled");
}

function trocarTipoDoc(idElemento, valor) {
    if (valor == "PF") {
        document.querySelector(idElemento).classList.remove("cnpj");
        document.querySelector(idElemento).classList.add("cpf");
    } else if (valor == "PJ") {
        document.querySelector(idElemento).classList.remove("cpf");
        document.querySelector(idElemento).classList.add("cnpj");
    }
    setMask();
}

function collapseIconChange(e, idIcon) {
    document.getElementById(idIcon).style.transform = 'rotate(' + ((e.ariaExpanded == 'true') ? '0' : '180') + 'deg)'
}

function confirmarRemoverAgenda(e, url, event, modalId) {
    if (!e.href) {
        e.href = url;
        event.preventDefault();
        e.innerHTML = 'Confirmar Remoção'
    }

    $("#" + modalId).on('hidden.bs.modal', function () {
        e.removeAttribute("href");
        e.innerHTML = 'Remover';
    });
}

function alterarAgenda(button, modalId, tituloLabel, inputTitulo, selectCor, event) {

    tituloAux = tituloLabel;
    parentTituloAux = tituloLabel.parentElement;

    button.innerHTML = 'Salvar';
    button.type = 'submit';
    event.preventDefault();

    tituloLabel.remove();
    inputTitulo.type = 'text';
    selectCor.removeAttribute("hidden");

    $("#" + modalId).on('hidden.bs.modal', function () {
        button.innerHTML = '<i class="fas fa-pen"></i> Alterar';
        parentTituloAux.insertBefore(tituloAux, parentTituloAux.children[0]);
        inputTitulo.type = 'hidden';
        selectCor.setAttribute("hidden", "");
        button.type = 'button';
    });
}
