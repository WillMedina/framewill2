CREATE PROCEDURE `storeprocedure_example`(IN parameter1 INT, IN parameter2 VARCHAR(100), IN parameter3 TEXT)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @sqlstate = RETURNED_SQLSTATE, 
		 @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
		-- SET @full_error = CONCAT("ERROR ", @errno, " (", @sqlstate, "): ", @text);
		SELECT @errno as 'RESULTADO', @sqlstate, @text;
	END;
    
    START TRANSACTION;
	/*** CODIGO SQL AQUI, ASEGURANDO SIEMPRE UNA COLUMNA DE SALIDA "RESULTADO" INCLUSO PARA INGRESO DE DATOS ****/
    COMMIT;
END