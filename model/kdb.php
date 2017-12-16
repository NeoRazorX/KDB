<?php

/// la clase se debe llamar igual que el archivo
class kdb extends fs_model {
  public $idkdb;
  public $sintoma;
  public $causa;
  public $solucion;
  public $observaciones;

  public function __construct($data = FALSE) {
    parent::__construct('kdb'); /// aquí indicamos el NOMBRE DE LA TABLA
    if($data) {
       $this->idkdb = $data['idkdb'];
       $this->sintoma = $data['sintoma'];
       $this->causa = $data['causa'];
       $this->solucion = $data['solucion'];
       $this->observaciones = $data['observaciones'];
    }else{
       $this->idkdb = null;
       $this->sintoma = null;
       $this->causa = null;
       $this->solucion = null;
       $this->observaciones = null;
    }
  }

  public function get_new_codigo(){
   $sql = "SELECT MAX(" . $this->db->sql_to_int('idkdb') . ") as cod FROM " . $this->table_name . ";";
   $data = $this->db->select($sql);
   if ($data) {
     return (string) (1 + (int) $data[0]['cod']);
   }
   return '1';
  }

  public function url() {
   if (is_null($this->idkdb)) {
     return "index.php?page=admin_kdb";
   }
   return "index.php?page=edit_kdb&cod=" . $this->idkdb;
  }

  public function get($cod) {
    $data = $this->db->select("SELECT * FROM " . $this->table_name . " WHERE idkdb = " . $this->var2str($cod) . ";");
    if ($data) {
      return new \kdb($data[0]);
    }
    return FALSE;
  }

  public function exists() {
    if(is_null($this->idkdb)) {
       return FALSE;
    }else{
       return $this->db->select("SELECT * FROM ".$this->table_name." WHERE idkdb = ".$this->var2str($this->idkdb).";");
    }
  }

  public function save() {
    if ($this->exists()){
      $sql = "UPDATE " . $this->table_name . " SET sintoma = " . $this->var2str($this->sintoma) .
        ", causa = " . $this->var2str($this->causa) .
        ", solucion = " . $this->var2str($this->solucion) .
        ", observaciones = " . $this->var2str($this->observaciones) .
        " WHERE idkdb = " . $this->idkdb . ";";
    }else{
      $sql = "INSERT INTO " . $this->table_name . " (idkdb,sintoma, causa, solucion, observaciones) VALUES
      (" . $this->var2str($this->idkdb) .
      "," . $this->var2str($this->sintoma) .
      "," . $this->var2str($this->causa) .
      "," . $this->var2str($this->solucion) .
      "," . $this->var2str($this->observaciones) .");";
    }
    return $this->db->exec($sql);
  }

  public function delete() {
    return $this->db->exec("DELETE FROM " . $this->table_name . " WHERE idkdb = " . $this->var2str($this->idkdb) . ";");
  }

  public function all() {
    $data = $this->db->select("SELECT * FROM " . $this->table_name . " ORDER BY idkdb ASC;");
    if ($data) {
      foreach ($data as $p) {
        $listak[] = new \kdb($p);
      }
    }
   return $listak;
  }

}
