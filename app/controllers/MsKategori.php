<?php
class MsKategori extends Controller
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
        $data['pages'] = "mskat";
        $data['page'] = "mskat";
        $this->view('templates/header');
        $this->view('templates/sidebar', $data);
        $this->view('mskategori/index', $data);
        $this->view('templates/footer');
    }

    public function SaveData()
    {

        $data = $this->model('MsKategoriModel')->SaveData($_POST);
        if (empty($data)) {
            $data = null;
            echo json_encode($data);
        } else {
            echo json_encode($data);
        }
    }

    public function TampilData()
    {
        $data = $this->model('MsKategoriModel')->TampilData();
        if (empty($data)) {
            $data = null;
            echo json_encode($data);
        } else {
            echo json_encode($data);
        }
    }

    public function Updatedata()
    {
        $data = $this->model('MsKategoriModel')->Updatedata($_POST);
        if (empty($data)) {
            $data = null;
            echo json_encode($data);
        } else {
            echo json_encode($data);
        }
    }

    public function Deletedata()
    {

        $data = $this->model('MsKategoriModel')->Deletedata($_POST);
        if (empty($data)) {
            $data = null;
            echo json_encode($data);
        } else {
            echo json_encode($data);
        }
    }
    public function tampilselectkatg()
    {
        $data = $this->model('MsKategoriModel')->TampilSelectKatg($_POST);
        if (empty($data)) {
            $data = null;
            echo json_encode($data);
        } else {
            echo json_encode($data);
        }
    }



    public function listkategori()
    {

        $data = $this->model('MsKategoriModel')->Listkategori();
        if (empty($data)) {
            $data = null;
            echo json_encode($data);
        } else {
            echo json_encode($data);
        }
    }


    public function listkategoriByID()
    {

        $data = $this->model('MsKategoriModel')->listkategoriByID($_POST);
        if (empty($data)) {
            $data = null;
            echo json_encode($data);
        } else {
            echo json_encode($data);
        }
    }
    public function listkategorifinalbyid()
    {
        $data = $this->model('MsKategoriModel')->listkategoriFinalByID($_POST);
        if (empty($data)) {
            $data = null;
            echo json_encode($data);
        } else {
            echo json_encode($data);
        }
    }
}
