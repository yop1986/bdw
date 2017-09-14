DELIMITER $$

DROP TRIGGER IF EXISTS transacciones_after_insert$$

CREATE TRIGGER transacciones_after_insert AFTER INSERT ON transacciones FOR EACH ROW begin
    if NEW.estado = 'Solicitado' then
        update cuentas set reserva = reserva + NEW.monto where id = NEW.cuenta_id;
    elseif NEW.estado = 'Autorizado' then
        update cuentas set balance = balance + NEW.monto where id = NEW.cuenta_id;
    end if;
end

$$
DELIMITER ;