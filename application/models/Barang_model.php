<?php
defined('BASEPATH') or exit('no direct access allowed');

class Barang_model extends CI_Model
{

	//Nabiel Izzullah Pansuri -- 19.01.4419
	public function get_barang($cari_nama = '', $cari_desk = '', $cari_stok = '')
	{
		$this->db->select('*');
		$this->db->from('barang');
		$this->db->where('isDeleted', 0);
		if ($cari_nama != '' && $cari_nama != null) {
			$this->db->like('nama_barang', $cari_nama);
		}
		if ($cari_desk != '' && $cari_desk != null) {
			$this->db->like('deskripsi', $cari_nama);
		}
		if ($cari_stok != '' && $cari_stok != null) {
			$this->db->where('stok <=', $cari_stok);
		}
		return $this->db->get();
	}

	public function insert_data($data)
	{
		$this->db->insert('barang', $data);
	}

	public function get_by_id($id_barang)
	{
		$this->db->select('*');
		$this->db->from('barang');
		$this->db->where('id_barang', $id_barang);
		return $this->db->get();
	}

	public function update_data($id_barang, $data)
	{
		$this->db->where('id_barang', $id_barang);
		$this->db->update('barang', $data);
	}

	public function hapus_data($id)
	{
		$this->db->where('id_barang', $id);
		$this->db->delete('barang');
	}
	
	public function soft_delete_data($id){
		$data_arr = array(
			'isDeleted' => 1
		);
		$this->db->where('id_barang', $id);
		$this->db->update('barang', $data_arr );
	}
}
