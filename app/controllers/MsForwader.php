<?php

class MsForwader  extends Controller {

	protected $userid;
	public function __construct()
	{	
	
		
		if($_SESSION['login_user'] == '') {
			Flasher::setMessage('Login','Tidak ditemukan.','danger');
			header('location: '. base_url . '/login');
			exit;
		}else{
			$this->userid = $_SESSION['login_user'];
		}
    }


    public function index(){
        	$data['pages'] = "msfor";
			$data['page'] = "msfor";
			$this->view('templates/header');
			$this->view('templates/sidebar',$data);
			$this->view('msforwader/index', $data);
			$this->view('templates/footer');
    }

    public function SaveData(){
        $data= $this->model('MsForwaderModel')->SaveData($_POST);
        if(empty($data)){
            $data = null;
            echo json_encode($data);
        }else{
            echo json_encode($data);
        }
    }


	public function TampilData(){
		$data= $this->model('MsForwaderModel')->TampilData();
        if(empty($data)){
            $data = null;
            echo json_encode($data);
        }else{
            echo json_encode($data);
        }
	}

	public function Updatedata(){
		$data= $this->model('MsForwaderModel')->Updatedata($_POST);
        if(empty($data)){
            $data = null;
            echo json_encode($data);
        }else{
            echo json_encode($data);
        }
	}



	public function TampilForwader(){
		$data= $this->model('MsForwaderModel')->TampilForwader($_POST);
			if(empty($data)){
				$data = null;
				echo json_encode($data);
			}else{
				echo json_encode($data);
			}
	}


	public function TampilForwaderEdit(){
		
		$data= $this->model('MsForwaderModel')->TampilForwaderEdit($_POST);
			if(empty($data)){
				$data = null;
				echo json_encode($data);
			}else{
				echo json_encode($data);
			}
	}

	
	public function tampilforwadereditfinal(){
		$data= $this->model('MsForwaderModel')->TampilForwaderEditFinal($_POST);
			if(empty($data)){
				$data = null;
				echo json_encode($data);
			}else{
				echo json_encode($data);
			}
	}
			 
}