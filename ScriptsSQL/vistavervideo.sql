CREATE 
VIEW judav.vistavervideo AS
    SELECT 
        judav.niveles.idNivel AS idNivel,
        judav.niveles.titulo AS titulo_nivel,
        judav.niveles.descripcion AS descripcion_nivel,
        judav.niveles.video AS url_video
    FROM
        judav.niveles;
        
        
        
select video from niveles where idNivel = 6;