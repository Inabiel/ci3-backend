<?php
	//Nabiel Izzullah Pansuri -- 19.01.4419
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Barang extends CI_Controller
{
	public function list_barang()
	{
		$this->load->model('Barang_model');
		$this->load->database();
		$data_barang = $this->Barang_model->get_barang();
		$konten = '<tr>
				   <td>nama</td>
				   <td>Deskripsi</td>
				   <td>Stok</td>
				   <td>aksi</td>
				   </tr>
		';

		foreach ($data_barang->result() as $key => $value) {
			$konten .= '<tr>
						<td>' . $value->nama_barang . '</td>
						<td>' . $value->deskripsi . '</td>		
						<td>' . $value->stok . '</td>
						<td>Read | Hapus | <a href="#' . $value->id_barang . '" class="linkEditBarang">Edit</a></td>
					</tr>
			';
		}

		$data_json = array(
			'konten' => $konten
		);

		echo json_encode($data_json);
	}
	public function create_action()
	{
		$this->load->model('Barang_model');
		$this->db->trans_start();
		$arr_input = array(
			'nama_barang' => $this->input->post('nama_barang'),
			'deskripsi' => $this->input->post('deskripsi'),
			'nama_admin' => $this->input->post('nama_admin'),
			'tanggal_barang_masuk' => $this->input->post('tanggal_barang_masuk'),
			'harga_barang' => $this->input->post('harga_barang'),
		);

		$this->Barang_model->insert_data($arr_input);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$data_output = array(
				'sukses' => 'tidak',
				'pesan' => 'gagal'
			);
		}
		$this->db->trans_commit();
		$data_output = array(
			'sukses' => 'ya',
			'pesan' => 'Data berhasil ditambahkan'
		);

		echo json_encode($data_output);
	}

	public function update_action()
	{
		$this->db->trans_start();
		$id_barang = $this->input->post('id_barang');
		$arr_input = array(
			'nama_barang' => $this->input->post('nama_barang'),
			'deskripsi' => $this->input->post('deskripsi')
		);

		$this->load->model('Barang_model');
		$this->Barang_model->update_data($id_barang, $arr_input);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$data_output = array(
				'sukses' => 'tidak',
				'pesan' => 'gagal update data barang'
			);
		}
		$this->db->trans_commit();
		$data_output = array(
			'sukses' => 'ya',
			'pesan' => 'berhasil update data barang'
		);

		echo json_encode($data_output);
	}

	public function detail()
	{
		$id = $this->input->get('id_barang');
		$this->load->model('Barang_model');
		$data_detail = $this->Barang_model->get_by_id($id);
		if ($data_detail->num_rows() > 0) {
			$data_output = array(
				'sukses' => 'ya',
				'detail' => $data_detail->row_array()
			);
		} else {
			$data_output = array(
				'sukses' => 'tidak'
			);
		}

		echo json_encode($data_output);
	}
}
