<?php
/// la clase se debe llamar igual que el archivo
class edit_kdb extends fs_controller {

  public $kdb;

  public function __construct() {
    /// se crea una entrada 'Mi controlador' dentro del menú 'Mio'
    parent::__construct(__CLASS__, 'Entrada', 'KDB', FALSE, FALSE);
  }

  protected function private_core() {
    parent::private_core();
    $this->ppage = $this->page->get('admin_kdb');
    $this->kdb = FALSE;
    if (isset($_GET['cod'])) {
      $kdb = new kdb();
      $this->kdb = $kdb->get($_GET['cod']);
    }

    if(isset($_POST['sintoma'])){
      $this->modificar();
    }

  }

  private function modificar() {
    if ($this->kdb) {
      $this->kdb->sintoma = $_POST['sintoma'];
      $this->kdb->causa = $_POST['causa'];
      $this->kdb->solucion = $_POST['solucion'];
      $this->kdb->observaciones = $_POST['observaciones'];

      if ($this->kdb->save()) {
        $this->new_message("Datos guardados correctamente.");
      } else {
        $this->new_error_msg("¡Imposible guardar!");
      }
    }
  }

  public function url() {
    if (!isset($this->kdb)) {
      return parent::url();
    } else if ($this->kdb) {
      return $this->kdb->url();
    }
    return $this->page->url();
  }

}
