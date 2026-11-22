<?php
// Modelo de galpones: dónde viven las aves y cuántas caben
class GalponModel {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    // Todos los galpones con sus aves vivas = ingresaron - muertas - vendidas
    public function listar() {
        return $this->con->query("
            SELECT g.*,
                   (SELECT IFNULL(SUM(l.cantidad), 0) FROM lotes l WHERE l.id_galpon = g.id_galpon)
                 - (SELECT IFNULL(SUM(r.muertas), 0)  FROM registros r JOIN lotes l ON l.id_lote = r.id_lote WHERE l.id_galpon = g.id_galpon)
                 - (SELECT IFNULL(SUM(v.cantidad), 0) FROM ventas v    JOIN lotes l ON l.id_lote = v.id_lote WHERE l.id_galpon = g.id_galpon) AS vivas
            FROM galpones g
            ORDER BY g.id_galpon")->fetchAll();
    }

    public function buscar($id) {
        $st = $this->con->prepare("SELECT * FROM galpones WHERE id_galpon = ?");
        $st->execute([$id]);
        return $st->fetch();
    }

    public function guardar($d) {
        $st = $this->con->prepare("INSERT INTO galpones (nombre, capacidad) VALUES (?, ?)");
        $st->execute([$d['nombre'], $d['capacidad']]);
    }

    public function actualizar($d) {
        $st = $this->con->prepare("UPDATE galpones SET nombre = ?, capacidad = ? WHERE id_galpon = ?");
        $st->execute([$d['nombre'], $d['capacidad'], $d['id_galpon']]);
    }

    public function eliminar($id) {
        $st = $this->con->prepare("DELETE FROM galpones WHERE id_galpon = ?");
        $st->execute([$id]);
    }
}
