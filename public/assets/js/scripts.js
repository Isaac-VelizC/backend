function mostrarOcultarElemento(inputId, containerId, checkboxId) {
    var input = document.getElementById(inputId);
    var container = document.getElementById(containerId);
    var checkbox = document.getElementById(checkboxId);

    if (input.value.trim() !== '') {
        container.style.display = 'block';
        checkbox.checked = false; // Configurar el estado del checkbox según tus necesidades
    } else {
        container.style.display = 'none';
        checkbox.checked = false; // Configurar el estado del checkbox según tus necesidades
    }
}
function toggleNotaInput(inputId, checkbox) {
    var notaInput = document.getElementById(inputId);
    notaInput.style.display = checkbox.checked ? 'block' : 'none';
    notaInput.value = checkbox.checked ? '' : null;
}