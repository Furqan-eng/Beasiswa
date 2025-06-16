<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beasiswa extends CI_Controller {

  public function __construct() {
    parent::__construct();
    // $this->load->model('Beasiswa_model');
  }

  public function index() {
    $data['calon'] = $this->session->userdata('calon') ?? [];
    $this->load->view('beasiswa_view', $data);
}


  public function simpan() {
    $nama = $this->input->post('nama');
    $nilai = $this->input->post('nilai');
    $penghasilan = $this->input->post('penghasilan');
    $aktivitas = $this->input->post('aktivitas');

    $Z = $this->hitung_z($nilai, $penghasilan, $aktivitas);
    $status = ($Z >= 0.5) ? 'LAYAK' : 'TIDAK LAYAK';

    $data_baru = [
        'nama' => $nama,
        'nilai' => $nilai,
        'penghasilan' => $penghasilan,
        'aktivitas' => $aktivitas,
        'z' => $Z,
        'status' => $status
    ];

    $calon = $this->session->userdata('calon') ?? [];
    $calon[] = $data_baru;

    $this->session->set_userdata('calon', $calon);

    redirect('beasiswa');
}


  private function fuzzy_r($x, $a, $b) {
    return max(0, min(1, ($b - $x) / ($b - $a)));
  }

  private function fuzzy_t($x, $a, $b) {
    return max(0, min(1, ($x - $a) / ($b - $a)));
  }

  private function hitung_z($nilai, $penghasilan, $aktivitas) {
    $mu = [
      'na_rendah' => $this->fuzzy_r($nilai, 70, 80),
      'na_tinggi' => $this->fuzzy_t($nilai, 70, 80),
      'po_rendah' => $this->fuzzy_r($penghasilan, 2, 3),
      'po_tinggi' => $this->fuzzy_t($penghasilan, 2, 3),
      'ae_rendah' => $this->fuzzy_r($aktivitas, 4, 5),
      'ae_tinggi' => $this->fuzzy_t($aktivitas, 4, 5),
    ];

    $alpha_layak = min($mu['na_tinggi'], $mu['po_rendah'], $mu['ae_tinggi']);
    $alpha_tidak = max($mu['na_rendah'], $mu['po_tinggi'], $mu['ae_rendah']);

    $z_layak = 1;
    $z_tidak = 0;

    if (($alpha_layak + $alpha_tidak) == 0) return 0;

    $Z = (($alpha_layak * $z_layak) + ($alpha_tidak * $z_tidak)) / ($alpha_layak + $alpha_tidak);

    return round($Z, 2);
  }
}