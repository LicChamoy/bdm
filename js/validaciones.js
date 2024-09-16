function togglePassword() {
    var passwordInput = document.getElementById("password");
    var confirmPasswordInput = document.getElementById("confirmarContra");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        confirmPasswordInput.type = "text";
    } else {
        passwordInput.type = "password";
        confirmPasswordInput.type = "password";
    }
}

function validarFormulario() {
    var nombres = document.getElementById("nombres").value;
    var apellidos = document.getElementById("apellidos").value;
    var correo = document.getElementById("correo").value;
    var usuario = document.getElementById("usuario").value;
    var password = document.getElementById("password").value;
    var Cpassword = document.getElementById("confirmarContra").value;
    var tipoCuenta = document.getElementById("tipo").value;
    var sexo = document.getElementById("sexo").value;

    var f = new Date();
    var mes = (f.getMonth() + 1).toString();
    var dia = f.getDate().toString();
    var fechaNac = document.getElementById("fecha_nacimiento").value;

    if (tipoCuenta === "") {
        alert("Por favor, selecciona tu tipo de cuenta.");
        return false;
    }
    
    if (sexo === "") {
        alert("Por favor, selecciona tu sexo.");
        return false;
    }


    if (mes.length <= 1) {
        mes = "0" + mes;
    }

    if (dia.length <= 1) {
        dia = "0" + dia;
    }
    var fechaActual = f.getFullYear() + "-" + mes + "-" + dia;

    if (fechaNac > fechaActual) {
        alert("La fecha seleccionada no se puede ingresar");
        return false;
    }

    var expresion = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/;
    var expresion2 = /^[a-zA-ZÀ-ÿ\s]+$/;
    var expresion3 = /^[a-zA-Z0-9\_\-]+$/;

    if (nombres === "" || apellidos === "" || correo === "" || usuario === "" || password === "" || Cpassword === "") {
        alert("Favor de ingresar todos los datos");
        return false;
    } else if (!expresion2.test(nombres)) {
        alert("El nombre tiene caracteres inválidos, solo ingresar letras");
        return false;
    } else if (!expresion2.test(apellidos)) {
        alert("Los apellidos tienen caracteres inválidos, solo ingresar letras");
        return false;
    } else if (usuario.length > 20) {
        alert("Nombre de usuario demasiado largo");
        return false;
    } else if (!expresion3.test(usuario)) {
        alert("El usuario contiene caracteres no válidos");
        return false;
    } else if (password.length < 8 || !/[a-z]/.test(password) || !/[A-Z]/.test(password) || !/[0-9]/.test(password) || !/[¡"#$%&/=?'!¿.:;(){}-]/.test(password)) {
        alert("La contraseña debe tener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un dígito y un signo de puntuación");
        return false;
    } else if (password !== Cpassword) {
        alert("Las contraseñas no coinciden");
        return false;
    }

    var regx = /^([a-zA-Z0-9\._]+)@([a-zA-Z0-9])+.([a-z])(.[a-z]+)?$/;

    if (regx.test(correo)) {
        return true;
    } else {
        alert("Favor de proporcionar un correo válido.");
        return false;
    }
}