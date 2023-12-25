<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends MY_Controller {

	private $limit = 15;
	private $table = 'news';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		$this->db->where('deleted_at', null);
		$this->db->order_by('id desc');
		$this->db->where('store_id', $this->session_login['session_store']['id']);
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
		$content_view['data'] 	= $this->db->get($this->table, $this->limit, $offset)->result();
		$content_view['offset'] = $offset;
		$content_view['paging'] = gen_paging($total,$this->limit);
		$content_view['total'] 	= gen_total($total,$this->limit,$offset);
		$data['content'] 	= $this->load->view('contents/news_view', $content_view, TRUE);

		$this->load->view('template_view', $data);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('title', 'Judul', 'trim|required');
	}
	
	private function _set_data($type = 'add')
	{
		$title 		= $this->input->post('title');
		$desc 		= $this->input->post('desc');
		$image 		= $this->input->post('image');
		$content 		= $this->input->post('content');
		$status 		= $this->input->post('status');

		$data = array(
            'title' => $title,
			'desc' => $desc,
			'image' => $image,
			'content' => $content,
			'status' => $status,
			'slug' => url_title($title, '-', true),
			'store_id' => $this->session_login['session_store']['id']
		);

		if($type == 'add'){
			$data['created_by'] = $this->session_login['id'];
			$data['created_at'] = date('Y-m-d H:i:s');
            if($status=='PUBLISH'){
			    $data['published_at'] = date('Y-m-d H:i:s');
            }
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
	public function detail($id)
	{
		$this->db->where('id', $id);
		$content_view['data'] = $this->db->get($this->table)->row();
		echo $this->load->view('contents/detail_news_view', $content_view, true);
	}

	public function add()
	{
		$this->_set_rules();
		if ($this->form_validation->run()===FALSE) {
			$data['content'] = $this->load->view('contents/form_news_view', [
				'action'=>base_url('news/add').get_query_string()
			],true);

			if(!validation_errors())
			{
                $data['script'] =  '<script src="'.base_url('assets') . '/plugins/tinymce_5/tinymce.min.js'.'"></script>';
				$data['script'] .=  '<script src="'.base_url('assets') . '/plugins/tinymce_5/jquery.tinymce.min.js'.'"></script>';;
				$data['script'] .= $this->load->view('script/news_script', '', true);
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
			$this->db->where('store_id', $this->session_login['session_store']['id']);
			$data_cat = $this->db->get($this->table)->row();
			if(empty($data_cat)){
				redirect('news');
			}
			$content_view['data'] = $data_cat;
			$content_view['action'] = base_url('news/edit/'.$id).get_query_string();
			$data['content'] = $this->load->view('contents/form_news_view',$content_view,true);

			if(!validation_errors())
			{
                $data['script'] =  '<script src="'.base_url('assets') . '/plugins/tinymce_5/tinymce.min.js'.'"></script>';
				$data['script'] .=  '<script src="'.base_url('assets') . '/plugins/tinymce_5/jquery.tinymce.min.js'.'"></script>';;
				$data['script'] .= $this->load->view('script/news_script', '', true);

				$this->load->view('template_view',$data);
			}
			else
			{
				echo json_encode(array('tipe'=>'error', 'title'=>'Terjadi Kesalahan !', 'message'=>strip_tags(validation_errors())));
			}

		}else{
            $data = $this->_set_data('edit');
            $published_at = $this->db->where('id', $id)->get($this->table)->row('published_at');
            if(empty($published_at) && $data['status']=='PUBLISH'){
                $data['published_at'] = date('Y-m-d H:i:s');
            }
			$this->db->where('store_id', $this->session_login['session_store']['id']);
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
			$this->db->where('store_id', $this->session_login['session_store']['id']);
			$this->db->delete($this->table, ['id'=>$id]);
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
