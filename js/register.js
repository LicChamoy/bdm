function togglePassword() {
    const passwordInput = document.getElementById('password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
}

function validarFormulario() {
    var nombres = document.getElementById("name").value;
    var correo = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var fechaNac = document.getElementById("dob").value;
    var sexo = document.getElementById("gender").value;
    var rol = document.getElementById("role").value;

    var f = new Date();
    var mes = (f.getMonth() + 1).toString();
    var dia = f.getDate().toString();

    if (rol === "") {
        alert("Por favor, selecciona tu rol.");
        return false;
    }
    
    if (sexo === "") {
        alert("Por favor, selecciona tu género.");
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

    if (nombres === "" || correo === "" || password === "") {
        alert("Favor de ingresar todos los datos");
        return false;
    }

    var regx = /^([a-zA-Z0-9\._]+)@([a-zA-Z0-9])+.([a-z])(.[a-z]+)?$/;

    if (!regx.test(correo)) {
        alert("Favor de proporcionar un correo válido.");
        return false;
    }

    if (password.length < 8 || !/[a-z]/.test(password) || !/[A-Z]/.test(password) || !/[0-9]/.test(password) || !/[¡"#$%&/=?'!¿.:;(){}-]/.test(password)) {
        alert("La contraseña debe tener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un dígito y un signo de puntuación");
        return false;
    }

    return true; // Todo está bien
}
