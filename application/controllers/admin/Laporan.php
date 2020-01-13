<?php
class Laporan extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('m_kategori');
		$this->load->model('m_barang');
		$this->load->model('m_suplier');
		$this->load->model('m_pembelian');
		$this->load->model('m_penjualan');
		$this->load->model('m_laporan');
		$this->load->library('Config_tcpdf');
	}
	function index(){
		if($this->session->userdata('akses')=='1'){
			$data['data']=$this->m_barang->tampil_barang();
			$data['kat']=$this->m_kategori->tampil_kategori();
			$data['jual_bln']=$this->m_laporan->get_bulan_jual();
			$data['jual_thn']=$this->m_laporan->get_tahun_jual();
			$this->load->view('admin/v_laporan',$data);
		}else{
			echo "Halaman tidak ditemukan";
		}
	}

	public function nota_kecil_kasir()
	{
		$data['data_jual'] = $this->m_laporan->get_jual();
		$data['data_jual_detail'] = $this->m_laporan->get_jual_detail();
		$this->load->view('admin/laporan/V_nota_kasir_kecil', $data);
		
	}

	public function testsession()
	{
//		echo $this->session->userdata('nofak');
		$data['data_jual'] = $this->m_laporan->get_jual_detail();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function lap_stok_barang(){
		$x['data']=$this->m_laporan->get_stok_barang();
		$this->load->view('admin/laporan/v_lap_stok_barang',$x);
	}
	function lap_data_barang(){
		$x['data']=$this->m_laporan->get_data_barang();
		$this->load->view('admin/laporan/v_lap_barang',$x);
	}
	function lap_data_penjualan(){
		$x['data']=$this->m_laporan->get_data_penjualan();
		$x['jml']=$this->m_laporan->get_total_penjualan();
		$this->load->view('admin/laporan/v_lap_penjualan',$x);
	}
	function lap_penjualan_pertanggal(){
		$tanggal=$this->input->post('tgl');
		$x['jml']=$this->m_laporan->get_data__total_jual_pertanggal($tanggal);
		$x['data']=$this->m_laporan->get_data_jual_pertanggal($tanggal);
		$this->load->view('admin/laporan/v_lap_jual_pertanggal',$x);
	}
	function lap_penjualan_perbulan(){
		$bulan=$this->input->post('bln');
		$x['jml']=$this->m_laporan->get_total_jual_perbulan($bulan);
		$x['data']=$this->m_laporan->get_jual_perbulan($bulan);
		$this->load->view('admin/laporan/v_lap_jual_perbulan',$x);
	}
	function lap_penjualan_pertahun(){
		$tahun=$this->input->post('thn');
		$x['jml']=$this->m_laporan->get_total_jual_pertahun($tahun);
		$x['data']=$this->m_laporan->get_jual_pertahun($tahun);
		$this->load->view('admin/laporan/v_lap_jual_pertahun',$x);
	}
	function lap_laba_rugi(){
		$bulan=$this->input->post('bln');
		$x['jml']=$this->m_laporan->get_total_lap_laba_rugi($bulan);
		$x['data']=$this->m_laporan->get_lap_laba_rugi($bulan);
		$this->load->view('admin/laporan/v_lap_laba_rugi',$x);
	}
}