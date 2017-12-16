<?php
require_once 'plugins/facturacion_base/extras/fbase_controller.php';
/// la clase se debe llamar igual que el archivo
class admin_kdb extends fbase_controller {

  public $kdb;
  public $resultados;
  public $offset;
  public $total_resultados;

  public function __construct() {
    /// se crea una entrada 'Mi controlador' dentro del menú 'Mio'
    parent::__construct(__CLASS__, 'Entrada', 'KDB');
  }

  protected function private_core() {
    parent::private_core();
    $this->kdb = new kdb();

    if (isset($_POST['ssintoma'])){
      $this->nuevo_kdb();
    }else if (isset($_GET['delete'])){
      $this->eliminar_kdb();
    }

    $this->ini_filters();
    $this->buscar();
  }

  private function ini_filters() {
    $this->offset = 0;
    if (isset($_GET['offset'])) {
      $this->offset = intval($_GET['offset']);
    }
  }

  private function nuevo_kdb(){
    $kdb0= new kdb();
    $kdb0->idkdb = $kdb0->get_new_codigo();
    $kdb0->sintoma = $_POST['ssintoma'];
    $kdb0->causa = $_POST['scausa'];
    $kdb0->solucion = $_POST['ssolucion'];
    $kdb0->observaciones = $_POST['sobservaciones'];
    if ($kdb0->save()) {
      $this->new_message("Entrada " . $age0->codagente . " guardada correctamente.");
      header('location: ' . $kdb0->url());
    } else {
      $this->new_error_msg("¡Imposible guardar la entrada!");
    }
  }

  private function eliminar_kdb(){
    $kdb0 = $this->kdb->get($_GET['delete']);
    if ($kdb0) {
      if ($kdb0->delete()) {
        $this->new_message("Entrada " . $kdb0->idkdb . " eliminada correctamente.");
      } else {
        $this->new_error_msg("¡Imposible eliminar la entrada!");
      }
    } else {
      $this->new_error_msg("¡Entrada no encontrado!");
    }
  }

  public function paginas() {
      $url = $this->url() . "&query=" . $this->query;
      return $this->fbase_paginas($url, $this->total_resultados, $this->offset);
  }

  private function buscar() {
    $this->total_resultados = 0;
    $query = $this->query;

    $data = $this->db->select("SELECT COUNT(idkdb) as total FROM kdb WHERE SINTOMA LIKE '%" . $query . "%'");
    if ($data) {
      $this->total_resultados = intval($data[0]['total']);
    }

    $data2 = $this->db->select("SELECT * FROM kdb WHERE SINTOMA LIKE '%" . $query . "%'");
    if ($data2) {
      foreach ($data2 as $d) {
        $this->resultados[] = new kdb($d);
      }
    }
  }

 }
