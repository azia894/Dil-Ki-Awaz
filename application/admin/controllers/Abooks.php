<?php
class Abooks extends CI_Controller{
	
	 public function __construct(){
		 parent::__construct();
		$this->is_not_logged_in();
		 $this->load->model('author_model');
         $this->load->model('books_model');
         $this->load->model('subject_model');
		  $this->load->library('datatbl');
	 }
	 
	 function index(){
		 //$data['get_data'] = $this->author_model->selectAll();
		 $data['main_content2'] = 'abooklist';		 
		 $this->load->view('template2/body',$data);
		 	 
	 }
	 
	 function is_not_logged_in(){
		$is_logged_in = $this->session->userdata('rcc_admin_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			redirect('login');			
		}				
	}
	
	
	 function add(){
        $data['get_data'] = $this->author_model->selectAll();
        $data['get_sub'] = $this->subject_model->selectAll();
		 $data['main_content2'] = 'add_abooks';
		 $this->load->view('template2/body',$data);
	 }
	 

	 function create(){
		
		extract($_POST);
		/*echo "<pre>";
		print_r($_FILES);
		print_r($_POST);*/
		$status=0;
		$msg='';
		$res = $this->books_model->getDetailsByName($this->input->post('bk_name'));
		if($res['num']>0){
			 $msg='<div class="alert alert-warning">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  <strong>"'.$this->input->post('bk_name').'" Book Name already exists</strong>
			</div>' ;
			}else if($this->input->post('bk_name')=='' ){
			  $msg='<div class="alert alert-warning">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  <strong>Please enter book name</strong>
			</div>' ;
			}else if($this->input->post('bk_desc')=='' ){
			  $msg='<div class="alert alert-warning">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  <strong>Please enter  description</strong>
			</div>' ;
			}else{	
			$insert_data = array(
                'author_id'=>$this->input->post('author_id'),
                'bk_age'=>$this->input->post('bk_age'),	
				'bk_name'=>$this->input->post('bk_name'),
				'bk_desc'=>$this->input->post('bk_desc'),
				'bk_type'=>2,
				'bk_status'=>1,	
                'created_on'=>date('Y-m-d H:i:s'),							
			);
			if(isset($_FILES['up']) && !empty($_FILES) && $_FILES['up']['name']!=""){		
						$fileTypes = array('jpeg','jpg','png','gif');
						$trgt='assets/bookimages/';
						$size = $_FILES['up']['size'];
						$file_name = $_FILES['up']['name'];
						$path_parts=pathinfo($_FILES['up']['name']);
						if(!in_array($path_parts['extension'],$fileTypes)){
							$msg='<div class="alert alert-warning">
									  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									  <strong>Only jpg,png are allowed</strong>
									</div>' ;
						 }else{
							$file = time().'.'.$path_parts['extension'];
							$insert_data['bk_img']=$file;
							move_uploaded_file($_FILES['up']['tmp_name'],$trgt.$file); 
							
						 }
					 }
			$q = $this->books_model->create($insert_data);
			if($q){		
	            $status=1;			
				 $msg='<div class="alert alert-success">
						  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <strong>Book Created Successfully!!</strong>
						</div>' ;
			}else{
				 $msg='<div class="alert alert-warning">
						  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <strong>Unable To Create, Try Again !!</strong>
						</div>' ;		
			}
		 }
		 $res = array('status'=>$status,'msg'=>$msg);
		echo json_encode($res); exit;
	}
	
	 function getBooksAllA(){
		$column = array('bkid','bk_name','created_on','bk_status','bk_img');
		$order = array('bkid' => 'desc');
		$join = array();
		$where="bkid!='' and bk_type='2'";
		$tb_name = 'aud_booktbl';
		$list = $this->datatbl->get_datatables($column,$order,$tb_name,$join,$where);
		$data = array();
		$no = $_POST['start'];
        $i=1;
		foreach ($list as $req) {
            
			$edit='&nbsp;&nbsp;<a href="'.base_url('abooks/edit/'.$req->bkid).'" class="label label-info" md-ink-ripple="">Edit</a>';
            $ch='<a href="'.base_url('chapter/list/'.$req->bkid).'"<button type="button" class="btn btn-primary">View Chapters</button>';
			$img='<img src="'.base_url('assets/bookimages/'.$req->bk_img).'" alt="image" class="img-responsive thumb-md">';
			$status = ($req->bk_status==1)?'<a href="'.base_url('abooks/deactive/'.$req->bkid).'"<span class="label label-success">Active</span>':'<a href="'.base_url('abooks/active/'.$req->bkid).'"<span class="label label-pink">In-Active</span>';
			$no++;
			$row = array();
			$row[] = $i;
			$row[] = $req->bk_name;
            $row[] = $ch;
			$row[] = $img;
			$row[] = $req->created_on;
			$row[] = $edit;
			//$row[] = $edit.'&nbsp;'.'<a href="'.base_url('books/del/'.$req->bkid).'" class="label label-danger" md-ink-ripple="">Delete</a>';
			$row[] = $status;
			$data[] = $row;
            $i++;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->datatbl->count_all($tb_name,$join,$where),
						"recordsFiltered" => $this->datatbl->count_filtered($column,$order,$tb_name,$join,$where),
						"data" => $data,
				);
		
		echo json_encode($output);
	}

	function edit(){
		$id = $this->uri->segment('3');
		$bd = $this->books_model->getDetails($id);
		if($bd['num']==1){	
			$data['get_data'] = $this->author_model->selectAll();
        $data['get_sub'] = $this->subject_model->selectAll();		 			
			$data['record'] = $bd['data'][0];
			$data['main_content2'] = 'edit_abooks';		 
			$this->load->view('template2/body',$data);
		}else{
			$this->session->set_flashdata('invalid','Invalid Request');
			redirect('abooks');
		}
	}

	function modify(){
		extract($_POST);
		 $status=0;
		 $msg='';
		 $id = $this->uri->segment('3');
		 $bd = $this->books_model->getDetails($id);
		 if($bd['num']==1){			
		 $res = $this->books_model->getDetailsByName($this->input->post('bk_name'));
		 if($this->input->post('bk_name')=='' ){
			   $msg='<div class="alert alert-warning">
			   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			   <strong>Please enter Book Name</strong>
			 </div>' ;
			 }else if($this->input->post('bk_desc')=='' ){
			   $msg='<div class="alert alert-warning">
			   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			   <strong>Please enter description</strong>
			 </div>' ;
			 }else{
				  $update_data = array();
				  $update_data = array(
					 'author_id'=>addslashes($this->input->post('author_id')),
					 'bk_age'=>addslashes($this->input->post('bk_age')),
					 'bk_desc'=>addslashes($this->input->post('bk_desc')),
									
					 );
				   if($res['num']==0){
					 $update_data['bk_name'] = addslashes($this->input->post('bk_name')); 
				  }
				 if(!empty($_FILES) && $_FILES['up']['name']!=""){		
						 $fileTypes = array('jpeg','jpg','png','gif');
						 $trgt='assets/bookimages/';
						 $size = $_FILES['up']['size'];
						 $file_name = $_FILES['up']['name'];
						 $path_parts=pathinfo($_FILES['up']['name']);
						 if(!in_array($path_parts['extension'],$fileTypes)){
							 $msg='<div class="alert alert-warning">
									   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									   <strong>Only jpg,png Images Are Allowed!!</strong>
									 </div>' ;
						  }else{
							 $file = time().'.'.$path_parts['extension'];
							 $update_data['bk_img']=$file;
							 move_uploaded_file($_FILES['up']['tmp_name'],$trgt.$file); 
							 
						  }
					  }
				  $q = $this->books_model->modify($update_data,$id);
				  if($q){
				 $status=1;
				// $this->session->set_flashdata('success','Page Updated successfully!!!!');
				$msg='<div class="alert alert-warning">
				   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				   <strong>Book Updated Successfully</strong></div>';	 
				 
					 }else{
							 $msg='<div class="alert alert-warning">
				   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				   <strong>Please Try Again Later</strong></div>';	 		 	
					 }	
			  }
		 }else{
			 $msg='<div class="alert alert-warning">
			   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			   <strong>Warning!</strong>Invalid action</div>';
		 }
		 
		  $res = array('status'=>$status,'msg'=>$msg);
		 echo json_encode($res); exit;	
	 }
	 
	 

	
	 function del(){
		$id = $this->uri->segment('3');
		$bd = $this->books_model->getDetails($id);
		if($bd['num']==1){	
			if($bd['data'][0]['bk_img']!=""){
				unlink('assets/bookimages/'.$bd['data'][0]['bk_img']);
			}
			$this->books_model->del($id);
			$this->session->set_flashdata('success','"'.$bd['data']['0']['bk_name'].'" books Deleted Successfully');
			redirect('books');			
		}else{
			$this->session->set_flashdata('invalid','Invalid Request');
			redirect('books');
		}
	}
	
	
	
	function active(){
		$id = $this->uri->segment('3');
			$update_data = array();
			  $update_data['bk_status'] = '1';        
			 $this->books_model->actived($update_data,$id);
			  $this->session->set_flashdata('success', 'Activated Successfully');
			 redirect('abooks');
	 }
	 function deactive(){
		$id = $this->uri->segment('3');
			$update_data = array();
			  $update_data['bk_status'] = '0';        
			 $this->books_model->inactived($update_data,$id);
			  $this->session->set_flashdata('success', 'Deactivated Successfully');
			 redirect('abooks');
	 }

	 
	
	}
