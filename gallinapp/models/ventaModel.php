<?php
// Modelo de ventas: aves vendidas de cada lote
class VentaModel {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    // El total de cada venta se calcula: cantidad x precio.
    // $f = filtros de búsqueda: comprador (por nombre) y rango de fechas
    public function listar($f = []) {
        $sql = "SELECT v.*, v.cantidad * v.precio AS total, t.nombre AS tipo, g.nombre AS galpon
                FROM ventas v
                JOIN lotes l    ON l.id_lote   = v.id_lote
                JOIN tipos t    ON t.id_tipo   = l.id_tipo
                JOIN galpones g ON g.id_galpon = l.id_galpon
                WHERE 1 = 1";
        $datos = [];
        if (!empty($f['comprador'])) { $sql .= " AND v.comprador LIKE ?"; $datos[] = '%' . $f['comprador'] . '%'; }
        if (!empty($f['desde']))     { $sql .= " AND v.fecha >= ?";       $datos[] = $f['desde']; }
        if (!empty($f['hasta']))     { $sql .= " AND v.fecha <= ?";       $datos[] = $f['hasta']; }

        $st = $this->con->prepare($sql . " ORDER BY v.fecha DESC, v.id_venta DESC");
        $st->execute($datos);
        return $st->fetchAll();
    }

    public function buscar($id) {
        $st = $this->con->prepare("SELECT * FROM ventas WHERE id_venta = ?");
        $st->execute([$id]);
        return $st->fetch();
    }

    public function guardar($d) {
        $st = $this->con->prepare("INSERT INTO ventas (id_lote, fecha, cantidad, precio, comprador) VALUES (?, ?, ?, ?, ?)");
        $st->execute([$d['id_lote'], $d['fecha'], $d['cantidad'], $d['precio'], $d['comprador']]);
    }

    public function actualizar($d) {
        $st = $this->con->prepare("UPDATE ventas SET id_lote = ?, fecha = ?, cantidad = ?, precio = ?, comprador = ? WHERE id_venta = ?");
        $st->execute([$d['id_lote'], $d['fecha'], $d['cantidad'], $d['precio'], $d['comprador'], $d['id_venta']]);
    }

    public function eliminar($id) {
        $st = $this->con->prepare("DELETE FROM ventas WHERE id_venta = ?");
        $st->execute([$id]);
    }
}
