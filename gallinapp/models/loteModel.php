<?php
// Modelo de lotes: guarda y consulta los lotes en la base de datos
class LoteModel {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    // Lotes con sus aves muertas y vendidas (para calcular las vivas) y la fecha
    // de su último registro diario (para las alertas).
    // $f = filtros de búsqueda: tipo de ave y galpón (si vienen vacíos, muestra todos)
    public function listar($f = []) {
        $sql = "SELECT l.*, t.nombre AS tipo, g.nombre AS galpon,
                       (SELECT IFNULL(SUM(muertas), 0)  FROM registros WHERE id_lote = l.id_lote) AS muertas,
                       (SELECT IFNULL(SUM(cantidad), 0) FROM ventas    WHERE id_lote = l.id_lote) AS vendidas,
                       (SELECT MAX(fecha)               FROM registros WHERE id_lote = l.id_lote) AS ultimo_registro
                FROM lotes l
                JOIN tipos t    ON t.id_tipo   = l.id_tipo
                JOIN galpones g ON g.id_galpon = l.id_galpon
                WHERE 1 = 1";
        $datos = [];
        if (!empty($f['id_tipo']))   { $sql .= " AND l.id_tipo = ?";   $datos[] = $f['id_tipo']; }
        if (!empty($f['id_galpon'])) { $sql .= " AND l.id_galpon = ?"; $datos[] = $f['id_galpon']; }

        $st = $this->con->prepare($sql . " ORDER BY l.id_lote");
        $st->execute($datos);
        return $st->fetchAll();
    }

    public function buscar($id) {
        $st = $this->con->prepare("SELECT * FROM lotes WHERE id_lote = ?");
        $st->execute([$id]);
        return $st->fetch();
    }

    // Aves vivas de un lote = ingresaron - muertas - vendidas (para las validaciones)
    public function vivas($id) {
        $st = $this->con->prepare("
            SELECT cantidad
                 - (SELECT IFNULL(SUM(muertas), 0)  FROM registros WHERE id_lote = ?)
                 - (SELECT IFNULL(SUM(cantidad), 0) FROM ventas    WHERE id_lote = ?)
            FROM lotes WHERE id_lote = ?");
        $st->execute([$id, $id, $id]);
        return $st->fetchColumn();
    }

    public function guardar($d) {
        $st = $this->con->prepare("INSERT INTO lotes (id_galpon, id_tipo, fecha_ingreso, cantidad) VALUES (?, ?, ?, ?)");
        $st->execute([$d['id_galpon'], $d['id_tipo'], $d['fecha_ingreso'], $d['cantidad']]);
    }

    public function actualizar($d) {
        $st = $this->con->prepare("UPDATE lotes SET id_galpon = ?, id_tipo = ?, fecha_ingreso = ?, cantidad = ? WHERE id_lote = ?");
        $st->execute([$d['id_galpon'], $d['id_tipo'], $d['fecha_ingreso'], $d['cantidad'], $d['id_lote']]);
    }

    public function eliminar($id) {
        $st = $this->con->prepare("DELETE FROM lotes WHERE id_lote = ?");
        $st->execute([$id]);
    }

    // Los 5 tipos de aves (para las listas de los formularios)
    public function tipos() {
        return $this->con->query("SELECT * FROM tipos ORDER BY id_tipo")->fetchAll();
    }

    // Para el panel: por cada tipo de ave, cuántas ingresaron, murieron y se vendieron
    public function resumenPorTipo() {
        return $this->con->query("
            SELECT t.nombre AS tipo,
                   (SELECT IFNULL(SUM(l.cantidad), 0) FROM lotes l WHERE l.id_tipo = t.id_tipo) AS ingresaron,
                   (SELECT IFNULL(SUM(r.muertas), 0)  FROM registros r JOIN lotes l ON l.id_lote = r.id_lote WHERE l.id_tipo = t.id_tipo) AS muertas,
                   (SELECT IFNULL(SUM(v.cantidad), 0) FROM ventas v    JOIN lotes l ON l.id_lote = v.id_lote WHERE l.id_tipo = t.id_tipo) AS vendidas
            FROM tipos t
            ORDER BY t.id_tipo")->fetchAll();
    }
}
