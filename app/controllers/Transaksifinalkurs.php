<?php

class Transaksifinalkurs extends Controller {

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

		public function index()
		{
	
			$data['pages'] = "inputkrusfinal";
			$data['page'] = "trans";
			$this->view('templates/header');
			$this->view('templates/sidebar',$data);
			$this->view('transaksifinalkurs/index', $data);
			$this->view('templates/footer');
		}


        public function ListData(){
                $data= $this->model('TransakiKurFinalModel')->ListData($_POST);
                        
                if(empty($data)){
                    $data = null;
                    echo json_encode($data);
                }else{
                    echo json_encode($data);
                }
            }


       
		public function tambah()
		{
			$data['pages'] = "inputkrusfinal";
			$data['page'] = "trans";
			$data['datapost'] =$_POST;
			$data["userid"] =$this->userid;
			$data['Supplier'] = $this->model('Supplier')->Tampildata();
			$this->view('templates/header');
			$this->view('templates/sidebar',$data);
			$this->view('transaksifinalkurs/tambah', $data);
			$this->view('templates/footer');
		}

		public function TampilpobySup(){

			$data= $this->model('PotransactionModel')->Tampilpobysup($_POST);
					
			if(empty($data)){
				$data = null;
				echo json_encode($data);
			}else{
				echo json_encode($data);
			}
		}




	public function SaveData(){
		// $jsondata = json_encode($_POST);
		// die(var_dump($jsondata));
		$post = json_decode(file_get_contents("php://input"), true);
        $data= $this->model('TransakiKurFinalModel')->SaveData($post);
        if(empty($data)){
            $data = null;
            echo json_encode($data);
        }else{
            echo json_encode($data);
        }
    }


	public function listfinal(){
			$data['pages'] = "listkrusfinal";
			$data['page'] = "trans";
			$this->view('templates/header');
			$this->view('templates/sidebar',$data);
			$this->view('transaksifinalkurs/listfinal', $data);
			$this->view('templates/footer');
	}

	public function listdatafinal(){
			$data= $this->model('TransakiKurFinalModel')->Listdatafinal($_POST);
			if(empty($data)){
				$data = null;
				echo json_encode($data);
			}else{  
				echo json_encode($data);
			}
	}



		public function edit(){
			$data['pages'] = "listkrusfinal";
			$data['page'] = "trans";
			$data['datapost'] =$_POST;
			$data["userid"] =$this->userid;
			$data['Supplier'] = $this->model('Supplier')->Tampildata();
			$this->view('templates/header');
			$this->view('templates/sidebar',$data);
			$this->view('transaksifinalkurs/edit', $data);
			$this->view('templates/footer');
		}


   public function ProsesGetkurEdit(){
		$data= $this->model('TransakiKurFinalModel')->ProsesGetkurEdit($_POST);
			if(empty($data)){
				$data = null;
				echo json_encode($data);
			}else{  
				echo json_encode($data);
			}
	}

	public function UpdateData(){
		$post = json_decode(file_get_contents("php://input"), true);
	 $data= $this->model('TransakiKurFinalModel')->UpdateData($post);
        if(empty($data)){
            $data = null;
            echo json_encode($data);
        }else{
            echo json_encode($data);
        }
	}

	public function Deletedata(){
		$data= $this->model('TransakiKurFinalModel')->DeleteAll($_POST);
        if(empty($data)){
            $data = null;
            echo json_encode($data);
        }else{
            echo json_encode($data);
        }
	}


		public function posting(){
			$data['pages'] = "listkrusfinal";
			$data['page'] = "trans";
			$data['datapost'] =$_POST;
			$data["userid"] =$this->userid;
			$data['Supplier'] = $this->model('Supplier')->Tampildata();
			$this->view('templates/header');
			$this->view('templates/sidebar',$data);
			$this->view('transaksifinalkurs/posting', $data);
			$this->view('templates/footer');
		}



	public function postingdata(){
		$post = json_decode(file_get_contents("php://input"), true);
        $data= $this->model('TransakiKurFinalModel')->PostingData($post);
        if(empty($data)){
            $data = null;
            echo json_encode($data);
        }else{
            echo json_encode($data);
        }
	}


		public function postlist(){
			$data['pages'] = "postfinal";
			$data['page'] = "post";
			$this->view('templates/header');
			$this->view('templates/sidebar',$data);
			$this->view('transaksifinalkurs/postlist', $data);
			$this->view('templates/footer');
		}

		public function ListSudahPosting(){
		
			$data= $this->model('TransakiKurFinalModel')->ListSudahPosting($_POST);
					
			if(empty($data)){
				$data = null;
				echo json_encode($data);
			}else{
				echo json_encode($data);
			}
		}

		public function Details(){
			$data['pages'] = "postfinal";
			$data['page'] = "trans";
			$data['datapost'] =$_POST;
			$data["userid"] =$this->userid;
			$data['Supplier'] = $this->model('Supplier')->Tampildata();
			$this->view('templates/header');
			$this->view('templates/sidebar',$data);
			$this->view('transaksifinalkurs/details', $data);
			$this->view('templates/footer');
		}
}