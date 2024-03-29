<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
   	{
    	parent::__construct();
		$this->load->library('session');
   	}

   	private function _set_rules()
	{
		$this->form_validation->set_rules('email','email','trim|required|callback_check_auth');
	}


	public function index()
	{
		$this->_set_rules();
		if($this->form_validation->run()===FALSE){
			if(!validation_errors())
			{
				$this->load->view('contents/login_view');
			}
			else
			{
				echo json_encode(array('tipe'=>'warning', 'title'=>'Terjadi Kesalahan !', 'message'=>strip_tags(validation_errors())));
			}


		}else{
			echo json_encode(array('action'=>'login','message'=>'Login Berhasil'));
		}
	}

	public function check_auth()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		if($email == '' || $password == ''){
			$this->form_validation->set_message('check_auth','Email and Password is required');
			return false;
		}

		$userdata = $this->db->select('id,fullname,password,store_id')->where('email', $email)->or_where('phone', $email)->get('user')->row_array();
		if (!empty($userdata) && password_verify($password, $userdata['password'])) {
			unset($userdata['password']);
			$this->db->select('role_module.id_module');
			$this->db->join('role_module','role_user.id_role=role_module.id_role','left');
			$modules = $this->db->where('id_user', $userdata['id'])->get('role_user')->result();
			if(empty($modules)){
				$this->form_validation->set_message('check_auth','Login gagal, Silakan Coba lagi');
				return false;	
			}
			foreach ($modules as $row) {
				$userdata['module'][] = $row->id_module;
			}
			$userdata['module'] = array_unique($userdata['module']);
			$stores = $this->db->where('user_id', $userdata['id'])->get('user_store')->result_array();
			if(empty($stores)){
				$this->form_validation->set_message('check_auth','Login gagal, Silakan Coba lagi');
				return false;	
			}

			$userdata['store'] = array_column($stores, 'store_id');
			$store_id = $stores[0]['store_id'];
			if(!empty($userdata['store_id'])){
				$store_id = $userdata['store_id'];
			}
			$userdata['session_store'] = $this->db->where('id', $store_id)->get('store')->row_array();

			$this->session->set_userdata('session_login', $userdata);
		
			return true;
		} else {
			$this->form_validation->set_message('check_auth','Login gagal, Silakan Coba lagi');
			return false;
		}
	}

	public function logout(){

		$this->session->unset_userdata('session_login');
		redirect('login');

	}
}