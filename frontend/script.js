function ocultarDetalles() {
    var detalles = document.getElementById('detalles-bloque');
    if (detalles) {
        detalles.style.display = 'none';
    }
}
//Boton editar y guardar actualizaciones de perfil
document.getElementById("btnEditar").addEventListener("click", function() {
    let inputs = document.querySelectorAll("input[type='text'], input[type='email'], input[type='file']");
    inputs.forEach(inp => {
        // Solo habilitar nombre, correo y avatar
        if (inp.name === "nombre" || inp.name === "correo" || inp.name === "avatar") {
            inp.removeAttribute("disabled");
        }
    });

    document.getElementById("btnGuardar").style.display = "inline-block";
    this.style.display = "none"; // Ocultamos el botón Editar
});