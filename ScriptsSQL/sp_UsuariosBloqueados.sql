DELIMITER //

create procedure UsuariosBloqueados()
begin

	SELECT 
    nombre, 
    apellidos, 
    email 
    FROM 
    UsuariosBloqueados;

end //

DELIMITER ;