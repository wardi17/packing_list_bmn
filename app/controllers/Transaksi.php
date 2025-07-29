<?php

class Transaksi extends Controller
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

		$data['pages'] = "input";
		$data['page'] = "trans";
		$this->view('templates/header');
		$this->view('templates/sidebar', $data);
		$this->view('transaksi/index', $data);
		$this->view('templates/footer');
	}


	public function tambah()
	{
		$tanggal = date("Y-m-d");
		$data['pages'] = "input";
		$data['page'] = "trans";
		$data["userid"] = $this->userid;
		$data['Supplier'] = $this->model('Supplier')->Tampildata();
		$this->view('templates/header');
		$this->view('templates/sidebar', $data);
		$this->view('transaksi/tambah', $data);
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

	public function TampilpobySupEdit()
	{

		$data = $this->model('PotransactionModel')->TampilpobysupEdit($_POST);

		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}

	public function tampildetailpo()
	{
		$data = $this->model('PotransactionModel')->TampilDetailpo($_POST);

		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}


	public function SimpanData()
	{

		$data = $this->model('PackingListModel')->SaveData($_POST);

		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}

	public function ListData()
	{


		$data = $this->model('PackingListModel')->ListData($_POST);

		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}


	public function edit()
	{

		$data['pages'] = "input";
		$data['page'] = "trans";
		$data['datapost'] = $_POST;
		$data["userid"] = $this->userid;
		$data['Supplier'] = $this->model('Supplier')->Tampildata();
		$this->view('templates/header');
		$this->view('templates/sidebar', $data);
		$this->view('transaksi/edit', $data);
		$this->view('templates/footer');
	}


	public function TampilEditDetailpo()
	{
		$data = $this->model('PackingListModel')->TampilEditDetailpo($_POST);

		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}


	public function TampilDetailPosting()
	{
		$data = $this->model('PackingListModel')->TampilDetailPosting($_POST);

		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}

	public function deletedata()
	{

		$data = $this->model('PackingListModel')->DeletePacking($_POST);

		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}



	public function UpdateData()
	{
		$data = $this->model('PackingListModel')->UpdateData($_POST);

		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}


	public function posting()
	{
		$data['pages'] = "input";
		$data['page'] = "trans";
		$data['datapost'] = $_POST;
		$data["userid"] = $this->userid;
		$data['Supplier'] = $this->model('Supplier')->Tampildata();
		$this->view('templates/header');
		$this->view('templates/sidebar', $data);
		$this->view('transaksi/posting', $data);
		$this->view('templates/footer');
	}


	public function simpanposting()
	{
		$data = $this->model('PackingListModel')->PostingData($_POST);

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
		$this->view('transaksi/postlist', $data);
		$this->view('templates/footer');
	}


	public function ListSudahPosting()
	{
		$data = $this->model('PackingListModel')->ListSudahPosting($_POST);

		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}



	public function Details()
	{
		$data['pages'] = "input";
		$data['page'] = "trans";
		$data['datapost'] = $_POST;
		$data["userid"] = $this->userid;
		$data['Supplier'] = $this->model('Supplier')->Tampildata();
		$this->view('templates/header');
		$this->view('templates/sidebar', $data);
		$this->view('transaksi/details', $data);
		$this->view('templates/footer');
	}
	//=====================================================================




















	public function getdatacustedit()
	{
		$data = $this->model('ChasDiscountModel')->getdataCastEdit($_POST);

		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}


	public function BatalData()
	{
		$data = $this->model('ChasDiscountModel')->BatalCastEdit($_POST);

		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}






	public function ViewPosting()
	{
		//$this->consol_war($_POST);
		$userid = (isset($_POST["userid"])) ?  $_POST["userid"] : '';

		if ($userid !== "") {
			$data = $this->model('ChasDiscountModel')->ViewBelumPosting($_POST);
			$this->view('transaksi/print', $data);
		} else {
			$this->view('templates/header');
			$this->view('templates/alertlog');
		}
	}




	public function Tampilposing()
	{
		$data['pages'] = "inv_cash";
		$data['page'] = "casch";
		$data['SoTransacID'] = (isset($_POST["SoTransacID"])) ?  $_POST["SoTransacID"] : '';
		$data['userid'] = (isset($_POST["userid"])) ?  $_POST["userid"] : '';

		$sotransaid = $data['SoTransacID'];
		$data['dataposting'] = $this->model('ChasDiscountModel')->TampilDataPosting($sotransaid);

		$this->view('templates/header');
		$this->view('templates/sidebar', $data);
		$this->view('transaksi/posting', $data);
		$this->view('templates/footer');
	}









	public function listposting()
	{
		$userid = (isset($_SESSION["login_user"])) ?  $_SESSION["login_user"] : '';




		$data["userid"] = $userid;

		$data['pages'] = "inv_cash";
		$data['page'] = "post";
		$this->view('templates/header');
		$this->view('templates/sidebar', $data);
		$this->view('sudahposting/index', $data);
		$this->view('templates/footer');
	}


	public function datasudahposting()
	{
		$data = $this->model('ChasDiscountModel')->ViewSudahPosting($_POST);

		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}


	public function TampilSudahposting()
	{

		$userid = (isset($_POST["userid"])) ?  $_POST["userid"] : '';

		if ($userid !== "") {
			$data = $this->model('ChasDiscountModel')->ViewBelumPosting($_POST);
			$this->view('sudahposting/print', $data);
		} else {
			$this->view('templates/header');
			$this->view('templates/alertlog');
		}
	}

	public function tampilnotepobyid()
	{
		$data = $this->model('PotransactionModel')->Tampilnotepobyid($_POST);
		if (empty($data)) {
			$data = null;
			echo json_encode($data);
		} else {
			echo json_encode($data);
		}
	}
}
