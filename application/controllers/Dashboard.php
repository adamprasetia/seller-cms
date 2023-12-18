<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	function __construct()
   	{
    	parent::__construct();
   	}

	public function index()
	{
		$content['store'] = $this->db->where_in('id', $this->session_login['store'])->get('store')->result();
		$content['total_category'] = $this->db->where('deleted_at', null)->where('store_id', $this->session_login['session_store']['id'])->count_all_results('category');
		$content['total_item'] = $this->db->where('deleted_at', null)->where('store_id', $this->session_login['session_store']['id'])->count_all_results('item');
		$data['content'] = $this->load->view('contents/dashboard_view', $content, TRUE);
		$data['script'] = $this->load->view('script/dashboard_script', '', TRUE);
		$this->load->view('template_view', $data);
	}

	public function switch_store($store_id)
	{
		// validasi
		$this->db->where('store_id', $store_id);
		$this->db->where('user_id', $this->session_login['id']);
		$valid = $this->db->count_all_results('user_store');
		if(!empty($valid)){
			$session_login = $this->session_login;
			$session_login['session_store'] = $this->db->where('id', $store_id)->get('store')->row_array();
			$this->session->set_userdata('session_login', $session_login);

			// update default
			$this->db->where('id', $this->session_login['id']);
			$this->db->update('user', ['store_id'=>$store_id]);
		}
		redirect();
	}

	public function store()
	{
		$store_id = $this->session_login['session_store']['id'];
		$content['action'] = site_url("store/edit/".$store_id);
		$content['redirect'] = base_url('dashboard/store');
		$content['table'] = "store";
		$content['title'] = "TOKO";
		$content['data'] = $this->db->where('id', $store_id)->get('store')->row();
		$data['content'] = $this->load->view('contents/form_store_view', $content, true);
		$this->load->view('template_view', $data);
	}

}
