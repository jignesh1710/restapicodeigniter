<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH .'libraries/REST_Controller.php';
class Welcome extends REST_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	// public function index_post()
	// {
	// 	$fname=$this->input->post("fname");
	// 	$lname=$this->input->post("lname");
	// 	$data=array(
	// 		"fname"=>$fname,
	// 		"lname"=>$lname
	// 	);
	// 	$post=$this->db->insert("tbl_student",$data);
	// 	if(empty($fname))
	// 	{
	// 		$message=array(
	// 			"message"=>"All Field Required",
	// 			"status"=>0,
				
	// 		);
	// 		$this->set_response($message,REST_Controller::HTTP_NOT_FOUND);
	// 	}
	// 	else{

		
	// 	if(!empty($post))
	// 	{
	// 		$message=array(
	// 			"message"=>"Insert Data",
	// 			"status"=>1,
	// 			"data"=>$data
	// 		);
	// 		$this->set_response($message,REST_Controller::HTTP_OK);

	// 	}
	// 	else{
	// 		$message=array(
	// 			"message"=>"Insert NOt Data",
	// 			"status"=>0,
	// 			"data"=>[]
	// 		);

	// 	}
	// }
		
	// }
	public function index_get()
	{
		$get=$this->db->get("tbl_student")->result_array();
		if(!empty($get))
		{
			$message=array(
				"status"=>1,
				"message"=>"Record Fetch",
				"data"=>$get
			);

		}
		else{
			$message=array(
				"status"=>0,
				"message"=>"Record Not Found",
				"data"=>[]
			);

		}
		$this->set_response($message,REST_Controller::HTTP_OK);
	}
	public function index_put()
	{
	
		// $lname=$this->input->post("lname");
		
		$data=json_decode(file_get_contents("php://input"));
		$fname=$data->fname;
		$data1=array(
			"fname"=>$data->fname,
			"lname"=>$data->lname
		);
		$id=$data->sid;
		$this->db->where('id',$id);
		$post=$this->db->update("tbl_student",$data1);
		if(empty($fname))
		{
			$message=array(
				"message"=>"All Field Required",
				"status"=>0,
				
			);
			$this->set_response($message,REST_Controller::HTTP_NOT_FOUND);
		}
		else{

		
		if(!empty($post))
		{
			$message=array(
				"message"=>"Update Data",
				"status"=>1,
				"data"=>$data
			);
			$this->set_response($message,REST_Controller::HTTP_OK);

		}
		else{
			$message=array(
				"message"=>"Insert NOt Data",
				"status"=>0,
				"data"=>[]
			);

		}
	}
		
	}
	public function index_delete()
	{
		$data=json_decode(file_get_contents("php://input"));
		$id=$data->sid;
		$this->db->where('id',$id);
		$delete=$this->db->delete("tbl_student");
		if(!empty($delete))
		{
			$message=array(
				"message"=>"Delete Data",
				"status"=>1
			);
		}
		else
		{
			$message=array(
				"message"=>"Delete Not Data",
				"status"=>0
			);
		}
		$this->set_response($message,REST_Controller::HTTP_OK);
	}
	public function index_post()
    {
		$this->load->helper(array("authorization","jwt"));
		$data=json_decode(file_get_contents("php://input"));
		$fname=$data->fname;
		$lname=$data->lname;
		// $data1=array(
		// 	"fname"=>$data->fname,
		// 	"lname"=>$data->lname
		// );
		
        $get_data=$this->db->query("select * from tbl_student where fname='$fname' and lname='$lname'")->row();
		$token=authorization::generateToken((array)$get_data);
		if($get_data)
		{
			$message=array(
				"message"=>"Login Successfully",
				"status"=>1,
				"token"=>$token,
				"data"=>$get_data
			);
		}
		else{
			$message=array(
				"message"=>"Login Not Successfully",
				"status"=>0
			);
		}
		$this->set_response($message,REST_Controller::HTTP_OK);
    }
}
