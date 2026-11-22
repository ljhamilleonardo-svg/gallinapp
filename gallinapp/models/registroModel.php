<?php
// Modelo del registro diario: aves muertas, alimento y agua de cada lote
class RegistroModel {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function listar() {
        return $this->con->query("
            SELECT r.*, t.nombre AS tipo, g.nombre AS galpon
            FROM registros r
            JOIN lotes l    ON l.id_lote   = r.id_lote
            JOIN tipos t    ON t.id_tipo   = l.id_tipo
            JOIN galpones g ON g.id_galpon = l.id_galpon
            ORDER BY r.fecha DESC, r.id_registro DESC")->fetchAll();
    }

    public function buscar($id) {
        $st = $this->con->prepare("SELECT * FROM registros WHERE id_registro = ?");
        $st->execute([$id]);
        return $st->fetch();
    }

    public function guardar($d) {
        $st = $this->con->prepare("INSERT INTO registros (id_lote, fecha, muertas, alimento_kg, agua_litros) VALUES (?, ?, ?, ?, ?)");
        $st->execute([$d['id_lote'], $d['fecha'], $d['muertas'], $d['alimento_kg'], $d['agua_litros']]);
    }

    public function actualizar($d) {
        $st = $this->con->prepare("UPDATE registros SET id_lote = ?, fecha = ?, muertas = ?, alimento_kg = ?, agua_litros = ? WHERE id_registro = ?");
        $st->execute([$d['id_lote'], $d['fecha'], $d['muertas'], $d['alimento_kg'], $d['agua_litros'], $d['id_registro']]);
    }

    public function eliminar($id) {
        $st = $this->con->prepare("DELETE FROM registros WHERE id_registro = ?");
        $st->execute([$id]);
    }
}
