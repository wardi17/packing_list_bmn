<?php
include("Transaksifinalkurs.php");
class Laporankursfinal extends Transaksifinalkurs{


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


    public function cetakprint(){
   
        $datas= $this->model('TransakiKurFinalModel')->cetakprint($_POST);
    //   die(var_dump($data));
        $data["datas"] =$datas;
        $data["status"]="FINAL";
        $this->view('laporankurs/print',$data);
    }


  public  function packing(){
        $data['pages'] = "lapfinal";
		$this->view('templates/header');
		$this->view('templates/sidebar',$data);
		$this->view('laporankursfinal/packing');
		$this->view('templates/footer2');
    }  

    public function ListLaporan(){
        $data= $this->model('TransakiKurFinalModel')->ListLaporan($_POST);
        if(empty($data)){
            $data = null;
            echo json_encode($data);
        }else{
            echo json_encode($data);
        }
    }


    //kode lama




  






//================================================================ laporan pib

    public function pib(){
        $data['pages'] = "pib";
            $this->view('templates/header');
            $this->view('templates/sidebar',$data);
            $this->view('laporan/pib');
            $this->view('templates/footer2');
    }
        
     public function ListLaporanpib(){
        $data= $this->model('PackingListModel')->ListLaporanPIB($_POST);
        if(empty($data)){
            $data = null;
            echo json_encode($data);
        }else{
            echo json_encode($data);
        }
    }

 
    public function cetakprintpib(){
   
        $data= $this->model('PackingListModel')->cetakprintpib($_POST);
    
        $this->view('laporan/printpib',$data);
    }



    public function hasilpib(){
            $data['pages'] = "hasilpib";
            $this->view('templates/header');
            $this->view('templates/sidebar',$data);
            $this->view('laporan/hasilpib');
            $this->view('templates/footer2');
    }


    public function listlaporanhasilpib(){
         $data= $this->model('PackingListModel')->ListLaporanPIB($_POST);
        if(empty($data)){
            $data = null;
            echo json_encode($data);
        }else{
            echo json_encode($data);
        }
    }


        public function CetakPrintHasilpib(){
   
        $data= $this->model('PackingListModel')->CetakPrintHasilpib($_POST);
    
        $this->view('laporan/printhasilpib',$data);
    }
}