DELIMITER $$

DROP TRIGGER IF EXISTS transacciones_after_update$$

CREATE TRIGGER transacciones_after_update AFTER UPDATE ON transacciones FOR EACH ROW begin
    if OLD.estado = 'Solicitado' AND NEW.estado = 'Autorizado' then
        update cuentas set reserva = reserva - OLD.monto, balance = balance + OLD.monto where id = NEW.cuenta_id;
    elseif OLD.estado = 'Solicitado' AND NEW.estado = 'Rechazado' then
        update cuentas set reserva = reserva - OLD.monto where id = NEW.cuenta_id;
    end if;
end

$$
DELIMITER ;