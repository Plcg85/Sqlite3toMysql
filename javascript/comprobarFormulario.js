//aqui se comprueba si lo introducido en el formulario son datos correctos
document.addEventListener("DOMContentLoaded", function () {

    const formulario = document.querySelector("form");
    const resultado = document.getElementById("resultado");

    formulario.addEventListener("submit", function (e) {

        e.preventDefault();//evita que se recargue la pagina
        const correo = document.getElementById("correo").value;
        const contrasena = document.getElementById("contrasena").value;
        const archivo = document.getElementById("archivo").files[0];
        const nombreArchivo = archivo.name;

        //si todo está correcto->
        if (correo === "plcgcpm2@gmail.com" && contrasena === "jj2hkr7g" && nombreArchivo === "MisCuentas.db") {
            resultado.textContent = "Credenciales válidas";
            resultado.style.color = "green";

            // Crear un objeto FormData para enviar los datos del formulario
            const formData = new FormData(formulario);

            // Enviar los datos al servidor manualmente
            fetch("convertir.php", {
                method: "POST",
                body: formData
            })
                .then(response => {
                    if (response.ok) {
                        return response.text(); // Leer respuesta del servidor
                    } else {
                        throw new Error("Error en el servidor al procesar el archivo.");
                    }
                })
                .then(data => {
                    resultado.textContent = "Archivo procesado con éxito.";
                    console.log("Respuesta del servidor:", data);
                    // Si es necesario, redirige a la página final o muestra algo
                })
                .catch(error => {
                    resultado.textContent = "Ocurrió un error durante el envío.";
                    resultado.style.color = "red";
                    console.error("Error:", error);
                });
        } else {
            resultado.textContent = "Credenciales no válidas.";
            resultado.style.color = "red";
        }

    });

});