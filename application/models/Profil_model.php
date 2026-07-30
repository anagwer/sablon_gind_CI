<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_profil() {
        $row = $this->db->get_where('profil_pondok', array('id' => 1))->row();
        if (!$row) {
            // Default object fallback if database table not yet populated
            return (object) array(
                'id' => 1,
                'nama_pesantren' => 'Pondok Pesantren Nurul Ulum',
                'tentang' => 'Pondok Pesantren Nurul Ulum Kabupaten Magelang...',
                'sejarah' => 'Didirikan sebagai pusat syiar Islam...',
                'legalitas_sk' => 'SK Kemenag No. 442/Kd.11.08/3/PP.00.7/2018',
                'alamat' => 'Jl. Pesantren Nurul Ulum, Kabupaten Magelang, Jawa Tengah 56152',
                'no_telp' => '0812-3456-7890',
                'email' => 'info@nurululum-magelang.sch.id',
                'bank_name' => 'Bank Syariah Indonesia (BSI)',
                'no_rekening' => '7123456789',
                'atas_nama' => 'YPP Nurul Ulum Magelang',
                'google_form_url' => 'https://forms.gle/imJr6QMbVd1XTRr27',
                'qris_image' => 'qris.jpeg',
                'map_iframe' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.3840711610915!2d110.23811627500137!3d-7.422677692587883!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a86ad7f77f3bf%3A0x2b9f90087c383ddc!2sPondok%20Pesantren%20Nurul%20Ulum!5e0!3m2!1sid!2sid!4v1784776267602!5m2!1sid!2sid" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>',
                'spp_mukim' => 750000.00,
                'spp_kampung' => 250000.00
            );
        }
        return $row;
    }

    public function update_profil($data) {
        $this->db->where('id', 1);
        return $this->db->update('profil_pondok', $data);
    }
}
