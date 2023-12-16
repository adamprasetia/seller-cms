<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Store extends MY_Controller {

	private $limit = 15;
	private $table = 'store';
	private $title = 'STORE';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		$this->db->where_in('id', $this->session_login['store']);
		$this->db->where('deleted_at', null);
		$search = $this->input->get('search');
		if ($search) {
			$this->db->like('title', $search);
		}
	}
	public function index()
	{
		$offset = gen_offset($this->limit);
		$this->_filter();
		$total = $this->db->count_all_results($this->table);
		$this->_filter();
		$content_view['title'] 	= $this->title;
		$content_view['table'] 	= $this->table;
		$content_view['data'] 	= $this->db->get($this->table, $this->limit, $offset)->result();
		$content_view['offset'] = $offset;
		$content_view['paging'] = gen_paging($total,$this->limit);
		$content_view['total'] 	= gen_total($total,$this->limit,$offset);
		$data['content'] 	= $this->load->view('contents/'.$this->table.'_view', $content_view, TRUE);

		$this->load->view('template_view', $data);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('domain', 'Domain', 'trim|required');
		$this->form_validation->set_rules('storage', 'Storage', 'trim|required');
	}
	
	private function _set_data($type = 'add')
	{
		$title 		= $this->input->post('title');
		$desc 		= $this->input->post('desc');
		$domain 		= $this->input->post('domain');
		$storage 		= $this->input->post('storage');
		$image 		= $this->input->post('image');

		$data = array(
			'title' => $title,
			'desc' => $desc,
			'storage' => $storage,
			'domain' => $domain,
			'image' => $image,
		);

		if($type == 'add'){
			$data['created_by'] = $this->session_login['id'];
			$data['created_at'] = date('Y-m-d H:i:s');
		}
		else if($type == 'edit'){
			$data['modified_by'] = $this->session_login['id'];
			$data['modified_at'] = date('Y-m-d H:i:s');
		}
		else if($type == 'delete'){
			$data = [
				'modified_by' => $this->session_login['id'],
				'deleted_at' => date('Y-m-d H:i:s')
			];
		}

		return $data;
	}
	public function add()
	{
		$this->_set_rules();
		if ($this->form_validation->run()===FALSE) {
            $content_view['title'] 	= $this->title;
            $content_view['table'] 	= $this->table;
            $content_view['action'] 	= base_url('store/add').get_query_string();
    
			$data['content'] = $this->load->view('contents/form_'.$this->table.'_view', $content_view, true);

			if(!validation_errors())
			{
				$this->load->view('template_view',$data);
			}
			else
			{
				echo json_encode(array('tipe'=>'warning', 'title'=>'Terjadi Kesalahan!', 'message'=>strip_tags(validation_errors())));
			}

		}else{
			$data = $this->_set_data();
			$this->db->insert($this->table, $data);
            $error = $this->db->error();
			if(empty($error['message'])){
				$response = array('id'=>$this->db->insert_id(), 'action'=>'insert', 'message'=>'Data berhasil disimpan');
			}else{
				$response = array('tipe'=>'warning', 'title'=>'Terjadi Kesalahan!', 'message'=>$error['message']);
			}

			echo json_encode($response);
		}
	}

	public function edit($id='')
	{
		$this->_set_rules();
		if ($this->form_validation->run()===FALSE) {
			$this->db->where('id', $id);
			$this->db->where('deleted_at', null);
			$this->db->where_in('id', $this->session_login['store']);
			$data_edit = $this->db->get($this->table)->row();
			if(!$data_edit){
				redirect($this->table);
			}
            $content_view['title'] 	= $this->title;
            $content_view['table'] 	= $this->table;
			$content_view['data'] = $data_edit;
			$content_view['action'] = base_url($this->table.'/edit/'.$id).get_query_string();
			$data['content'] = $this->load->view('contents/form_'.$this->table.'_view',$content_view,true);

			if(!validation_errors())
			{
				$this->load->view('template_view',$data);
			}
			else
			{
				echo json_encode(array('tipe'=>'error', 'title'=>'Terjadi Kesalahan !', 'message'=>strip_tags(validation_errors())));
			}

		}else{
			$data = $this->_set_data('edit');
			$this->db->where_in('id', $this->session_login['store']);
			$this->db->where('id', $id);
            $this->db->update($this->table, $data);
			$error = $this->db->error();
			if(empty($error['message'])){
				$response = array('id'=>$id, 'action'=>'update', 'message'=>'Data berhasil disimpan');
			}else{
				$response = array('tipe'=>'warning', 'title'=>'Terjadi Kesalahan!', 'message'=>$error['message']);
			}

			echo json_encode($response);
		}
	}

	public function delete($id = '')
	{
		if ($id) {
            $data = $this->_set_data('delete');
			$this->db->where_in('id', $this->session_login['store']);
			$this->db->where('id', $id);
            $this->db->update($this->table, $data);
			$error = $this->db->error();
			if(empty($error['message'])){
				$response = array('id'=>$id, 'action'=>'delete', 'message'=>'Data berhasil dihapus');
			}else{
				$response = array('tipe'=>'warning', 'title'=>'Terjadi Kesalahan!', 'message'=>$error['message']);
			}
			echo json_encode($response);
		}
	}

}
