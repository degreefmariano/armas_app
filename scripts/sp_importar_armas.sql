CREATE OR REPLACE PROCEDURE public.sp_import_armas_excel(	
	p_tipo_arma integer,
	p_fecha_alta varchar(10),
	p_obs varchar(255)
)
 LANGUAGE plpgsql
AS $procedure$
DECLARE
    v_row record;
    v_serie varchar(20);
    v_tipo int;
    v_marca int;
    v_calibre int;
    v_medida_calibre integer := 2;
    v_uso integer := 1;
    v_modelo varchar(255);
    v_fecha_alta date := TO_DATE(p_fecha_alta, 'YYYY-MM-DD');
    v_id_usr integer := 16;
    v_ud integer := 24;
    v_seccion_operador character varying := '240103000000'; -- DIVISIÓN ARMAMENTO - D4
    v_obs varchar(255) := p_obs;
BEGIN
    -- Abrir un cursor para obtener las filas de import_armas_excel
    FOR v_row IN SELECT * FROM import_armas_excel LOOP
        -- Obtener los valores de la fila actual
        v_serie := v_row.serie;
        v_tipo := v_row.tipo;
        v_marca := v_row.marca;
        v_calibre := v_row.calibre;
        v_modelo := v_row.modelo;
        
        -- Buscar si ya existe un registro en la tabla arma
        PERFORM 1 FROM arma
        WHERE nro_arma = v_serie
        AND cod_tipo_arma = v_tipo
        AND cod_marca = v_marca
        AND cod_calibre_principal = v_calibre;

        IF FOUND THEN
            -- Actualizar el registro en import_armas_excel
            UPDATE import_armas_excel
            SET estado = 'ERROR',
                comentario = 'Error, registro duplicado'
            WHERE serie = v_serie
            AND tipo = v_tipo
            AND marca = v_marca
            AND calibre = v_calibre;
        ELSE
            -- Insertar en la tabla arma
            INSERT INTO arma (nro_arma, 
                                cod_tipo_arma, 
                                cod_marca, 
                                cod_calibre_principal,
                                medida_calibre_principal,
                                clasificacion,
                                arma_corta_larga,
                                modelo, 
                                cod_legajo, 
                                legajo,
                                estado,
                                situacion, 
                                sub_situacion, 
                                ud_ar, 
                                fecha_alta, 
                                id_usr, 
                                ud,
                                seccion_operador,
                                obs)
            VALUES (v_serie, v_tipo, v_marca, v_calibre, v_medida_calibre, v_uso, p_tipo_arma, v_modelo, 4, 9342000, 1, 3, 1, 24, v_fecha_alta, v_id_usr, v_ud, v_seccion_operador, v_obs);

            -- Actualizar el registro en import_armas_excel
            UPDATE import_armas_excel
            SET estado = 'OK'
            WHERE serie = v_serie
            AND tipo = v_tipo
            AND marca = v_marca
            AND calibre = v_calibre;
        END IF;
    END LOOP;
END;
$procedure$
;