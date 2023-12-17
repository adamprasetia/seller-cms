<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends MY_Controller {

	private $limit = 15;
	private $table = 'item';

	function __construct()
   	{
    	parent::__construct();
   	}
	private function _filter()
	{
		$this->db->where('store_id', $this->session_login['session_store']['id']);
		$this->db->where('deleted_at', null);
		$search = $this->input->get('search');
		if ($search) {
			$this->db->group_start();
			$this->db->like('name', $search);
			$this->db->group_end();
		}
	}
	public function index()
	{
		$offset = gen_offset($this->limit);
		$this->_filter();
		$total = $this->db->count_all_results($this->table);
		$this->_filter();
		$content_view['data'] 	= $this->db->order_by('id desc')->get($this->table, $this->limit, $offset)->result();
		$content_view['offset'] = $offset;
		$content_view['paging'] = gen_paging($total,$this->limit);
		$content_view['total'] 	= gen_total($total,$this->limit,$offset);
		$data['content'] 	= $this->load->view('contents/item_view', $content_view, TRUE);

		$this->load->view(!empty($this->input->get('popup'))?'modals/template_view':'template_view', $data);
	}

	private function _set_rules()
	{
		$this->form_validation->set_rules('name', 'Nama', 'trim|required');
		$this->form_validation->set_rules('image', 'Image', 'trim|required');
	}
	
	private function _set_data($type = 'add')
	{
		$name		= $this->input->post('name');
		$image		= $this->input->post('image');
		$cover		= $this->input->post('cover');
		$cover_mobile		= $this->input->post('cover_mobile');
		$desc		= $this->input->post('desc');
		$teaser		= $this->input->post('teaser');
		$keyword		= $this->input->post('keyword');
		$category_id		= $this->input->post('category_id');
		$rank		= $this->input->post('rank');
		$headline		= $this->input->post('headline');
		$price		= $this->input->post('price');
		$video		= $this->input->post('video');
		$gallery		= $this->input->post('gallery');

		$data = array(
			'store_id' => $this->session_login['session_store']['id'],
			'name' => $name,
			'slug' => url_title($name,'-',true),
			'image' => $image,
			'cover' => $cover,
			'cover_mobile' => $cover_mobile,
			'desc' => $desc,
			'teaser' => $teaser,
			'keyword' => $keyword,
			'category_id' => $category_id,
			'rank' => $rank,
			'headline' => $headline,
			'price' => $price,
			'video' => $video,
		);
		if(!empty($gallery)){
			$data['gallery'] = json_encode($gallery);
		}
		$data['video_id'] = '';
		if(!empty($video) && strpos($video, 'youtube.com') !== false){
			$video_id = explode("?v=", $video); // For videos like http://www.youtube.com/watch?v=...
			if (empty($video_id[1]))
				$video_id = explode("/v/", $video); // For videos like http://www.youtube.com/watch/v/..

			$video_id = explode("&", $video_id[1]); // Deleting any other params
			$data['video_id'] = $video_id[0];
		}

		if(!empty($_FILES['pdf']['name'])){
			// upload
			$upload_path = FCPATH.'assets/pdf';
			$upload_path = str_replace(array('cms/','\cms'), '', $upload_path);	
			if (!is_dir($upload_path)) {
				if(!@mkdir($upload_path, 0755, true)){
					$error = error_get_last();
					echo json_encode(array('tipe'=>'warning', 'title'=>'Terjadi Kesalahan!', 'message'=>$error));
					exit;
				}
			}
	
			$config['upload_path']          = $upload_path;
            $config['allowed_types']        = 'pdf';
			$config['max_size']             = 10000;

            $this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('pdf'))
			{
				echo json_encode(array('tipe'=>'warning', 'title'=>'Terjadi Kesalahan!', 'message'=>$this->upload->display_errors()));
				exit;
			}
			else
			{
				$upload_data = $this->upload->data();
				$data['pdf'] = $upload_data['file_name'];
			}
		}


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
			$data['content'] = $this->load->view('contents/form_item_view', [
				'action'=>base_url('item/add').get_query_string(),
				'category'=>$this->db->where('store_id', $this->session_login['session_store']['id'])->get('category')->result()
			],true);

			if(!validation_errors())
			{
				$data['script'] =  '<script src="'.base_url('assets') . '/plugins/tinymce_5/tinymce.min.js'.'"></script>';
				$data['script'] .=  '<script src="'.base_url('assets') . '/plugins/tinymce_5/jquery.tinymce.min.js'.'"></script>';;
				$data['script'] .= $this->load->view('script/item_script', '', true);
	
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
			$content_view['data'] = $this->db->get($this->table)->row();
			$content_view['action'] = base_url('item/edit/'.$id).get_query_string();
			$content_view['category'] = $this->db->where('store_id', $this->session_login['session_store']['id'])->get('category')->result();
			$data['content'] = $this->load->view('contents/form_item_view',$content_view,true);

			if(!validation_errors())
			{
				$data['script'] =  '<script src="'.base_url('assets') . '/plugins/tinymce_5/tinymce.min.js'.'"></script>';
				$data['script'] .=  '<script src="'.base_url('assets') . '/plugins/tinymce_5/jquery.tinymce.min.js'.'"></script>';;
				$data['script'] .= $this->load->view('script/item_script', '', true);

				$this->load->view('template_view',$data);
			}
			else
			{
				echo json_encode(array('tipe'=>'error', 'title'=>'Terjadi Kesalahan !', 'message'=>strip_tags(validation_errors())));
			}

		}else{
			$data = $this->_set_data('edit');
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
