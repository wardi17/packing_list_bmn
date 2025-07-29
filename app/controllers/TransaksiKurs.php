<?php

class TransaksiKurs extends Controller
{

	protected $userid;
	public function __construct()
	{


		if ($_SESSION['login_user'] == '') {
			Flasher::setMessage('Login', 'Tidak ditemukan.', 'danger');
			header('location: ' . base_url . '/login');
			exit;
		} else {
			$this->userid = $_SESSION['login_user'];
		}
	}

	public function index()
	{

		$data['pages'] = "inputkrus";
		$data['page'] = "trans";
		$this->view('templates/header');
		$this->view('templates/sidebar', $data);
		$this->view('transaksikurs/index', $data);
		$this->view('templates/footer');
	}


	public function tambah()
	{
		$token = CsrfToken::generate();

		$tanggal = date("Y-m-d");
		$data['pages'] = "inputkrus";
		$data['page'] = "trans";
		$data["userid"] = $this->userid;
		$data['Supplier'] = $this->model('Supplier')->Tampildata();
		$this->view('templates/header');
		$this->view('templates/sidebar', $data);
		$this->view('transaksikurs/tambah', $data);
		$this->view('templates/footer');
	}

	public function TampilpobySup()
	{

		$data = $this->model('PotransactionModel')->Tampilpobysup($_POST);

		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}


	public function ProsesGetkur()
	{
		$data = $this->model('TransakiKurModel')->ProsesGetkur($_POST);
		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}

	public function SaveData()
	{
		//$jsondata = json_encode($_POST);
		// die(var_dump('wardi'));
		$post = json_decode(file_get_contents("php://input"), true);
		$data = $this->model('TransakiKurModel')->SaveData($post);
		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}

	public function ListData()
	{
		$data = $this->model('TransakiKurModel')->ListData($_POST);

		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}


	public function edit()
	{

		$data['pages'] = "inputkrus";
		$data['page'] = "trans";
		$data['datapost'] = $_POST;
		$data["userid"] = $this->userid;
		$data['Supplier'] = $this->model('Supplier')->Tampildata();
		$this->view('templates/header');
		$this->view('templates/sidebar', $data);
		$this->view('transaksikurs/edit', $data);
		$this->view('templates/footer');
	}


	public function ProsesGetkurEdit()
	{
		$data = $this->model('TransakiKurModel')->ProsesGetkurEdit($_POST);
		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}

	public function UpdateData()
	{
		$post = json_decode(file_get_contents("php://input"), true);
		$data = $this->model('TransakiKurModel')->UpdateData($post);
		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}

	public function Deletedata()
	{
		$data = $this->model('TransakiKurModel')->DeleteAll($_POST);
		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}


	public function posting()
	{
		$data['pages'] = "inputkrus";
		$data['page'] = "trans";
		$data['datapost'] = $_POST;
		$data["userid"] = $this->userid;
		$data['Supplier'] = $this->model('Supplier')->Tampildata();
		$this->view('templates/header');
		$this->view('templates/sidebar', $data);
		$this->view('transaksikurs/posting', $data);
		$this->view('templates/footer');
	}



	public function postingdata()
	{
		$post = json_decode(file_get_contents("php://input"), true);
		$data = $this->model('TransakiKurModel')->PostingData($post);
		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}


	public function postlist()
	{
		$data['pages'] = "post";
		$data['page'] = "post";
		$this->view('templates/header');
		$this->view('templates/sidebar', $data);
		$this->view('transaksikurs/postlist', $data);
		$this->view('templates/footer');
	}

	public function ListSudahPosting()
	{
		$data = $this->model('TransakiKurModel')->ListSudahPosting($_POST);

		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}

	public function Details()
	{
		$data['pages'] = "post";
		$data['page'] = "trans";
		$data['datapost'] = $_POST;
		$data["userid"] = $this->userid;
		$data['Supplier'] = $this->model('Supplier')->Tampildata();
		$this->view('templates/header');
		$this->view('templates/sidebar', $data);
		$this->view('transaksikurs/details', $data);
		$this->view('templates/footer');
	}
}
