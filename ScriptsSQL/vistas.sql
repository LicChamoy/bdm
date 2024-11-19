CREATE VIEW UsuarioLoginView AS
SELECT idUsuario, email, contraseña, rol, estado
FROM usuarios;

CREATE VIEW UsuariosBloqueados AS
SELECT 
    nombre, 
    apellidos, 
    email 
FROM 
    usuarios 
WHERE 
    estado = 'baja';
