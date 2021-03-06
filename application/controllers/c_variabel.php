<?php
class C_Variabel extends CI_Controller{

   /**validasi INPUTAN VARIABEL */
   public function _rules(){
    $this->form_validation->set_rules('a','Nilai A','required|numeric');
    $this->form_validation->set_rules('b','Nilai B','required|numeric');
    $this->form_validation->set_rules('c','Nilai C','required|numeric');
    
}
/**end validasi INPUTAN VARIABEL */

/**tabel variabel kategori penduduk */
public function VariabelPenduduk(){
  // $data['c_variabel']=$this->m_variabel->pembobotan_penduduk();
  // $data['kesejahteraan']=$this->m_variabel->tb_tingkat_kesejahteraan();
    $data['c_variabel'] = $this->m_variabel->tabel_variabel()->result();
    $this->load->view('templates/header');
    $this->load->view('admin/inputdata/variabel/penduduk/v_tabel',$data); //input_bobot
    $this->load->view('templates/footer');
}

public function bobot_Penduduk(){
   $data['c_variabel']=$this->m_variabel->pembobotan_penduduk();
   $data['kesejahteraan']=$this->m_variabel->tb_tingkat_kesejahteraan();
    $data['kriteria'] = $this->m_variabel->tabel_variabel();
    $data['aset'] = $this->m_variabel->tabel_variabel_aset();
    $data['program'] = $this->m_variabel->tabel_variabel_program();
    $this->load->view('templates/header');
    $this->load->view('admin/inputdata/variabel/penduduk/input_bobot',$data); //
    $this->load->view('templates/footer');
}


  /**tambah kategori penduduk */
  public function tambah_var_penduduk(){
    $this->load->view('templates/header');
    $this->load->view('admin/inputdata/variabel/penduduk/v_tambah');
    $this->load->view('templates/footer');
}

/**insert tambah kategori penduduk */
function insert_var_penduduk(){
    $this->load->model('m_variabel');


    $nama_variabel = $this->input->post('nama_variabel');
 
    $dt=$this->input->post();
    $nama = $this->input->post('nama');
    $skor = $this->input->post('skor');

    $query = $this->m_variabel->insert($nama_variabel);
    $variabel_id = $query['max'];
    $i = 0;
    
    foreach($nama as $key) {
         $this->m_variabel->insert_sub_variabel($variabel_id, $key, $skor[$i]);
         $i++;
     }

     redirect('c_variabel/VariabelPenduduk');
  }

/** -- edit variabel penduduk -- */

    public function edit_variabel($id){
       $data['c_variabel'] = $this->m_variabel->edit_variabel($id);
       $data['sub_variabel'] = $this->m_variabel->edit_sub_variabel($id);

        $this->load->view('templates/header');
        $this->load->view('admin/inputdata/variabel/penduduk/v_edit',$data); //
        $this->load->view('templates/footer');
    }

    public function edit_variabel_aset($id){
      $data['c_variabel'] = $this->m_variabel->edit_variabel_aset($id);
      $data['sub_variabel'] = $this->m_variabel->edit_sub_variabel_aset($id);

       $this->load->view('templates/header');
       $this->load->view('admin/inputdata/variabel/penduduk/v_edit_aset',$data); //
       $this->load->view('templates/footer');
   }

   public function edit_variabel_program($id){
    $data['c_variabel'] = $this->m_variabel->edit_variabel_program($id);
    $data['sub_variabel'] = $this->m_variabel->edit_sub_variabel_program($id);

     $this->load->view('templates/header');
     $this->load->view('admin/inputdata/variabel/penduduk/v_edit_program',$data); //
     $this->load->view('templates/footer');
 }

    /**update variabel penduduk */
    function update_variabel_penduduk(){
  
      $dt=$this->input->post();

      $array=array('nama_variabel'=>$dt['nama_variabel']);
      $where=array('variabel_id'=>$dt['variabel_id']);
      $p=$this->m_variabel->update_variabel_penduduk($where,$array,'tb_variabel');
    
      for ($i=0; $i<count($dt['sub_id']) ; $i++) {
        $batch[] = array('sub_id'=>$dt['sub_id'][$i],
        'sub_variabel_id'=>$dt['sub_variabel_id'][$i],
        'nama'=>$dt['nama'][$i],
        'skor'=>$dt['skor'][$i]
      );
    }
    $q=$this->db->update_batch('tb_sub_variabel', $batch, 'sub_id');
    
    redirect('c_variabel/bobot_Penduduk');
  }

  function update_variabel_penduduk_aset(){
  
    $dt=$this->input->post();

    $array=array('nama_variabel'=>$dt['nama_variabel']);
    $where=array('variabel_id'=>$dt['variabel_id']);
    $p=$this->m_variabel->update_variabel_penduduk_aset($where,$array,'tb_variabel_aset');
  
    for ($i=0; $i<count($dt['sub_id']) ; $i++) {
      $batch[] = array('sub_id'=>$dt['sub_id'][$i],
      'sub_variabel_id'=>$dt['sub_variabel_id'][$i],
      'nama'=>$dt['nama'][$i],
      'skor'=>$dt['skor'][$i]
    );
  }
  $q=$this->db->update_batch('tb_sub_variabel_aset', $batch, 'sub_id');
  
  redirect('c_variabel/bobot_Penduduk');
}

function update_variabel_penduduk_program(){
  
  $dt=$this->input->post();

  $array=array('nama_variabel'=>$dt['nama_variabel']);
  $where=array('variabel_id'=>$dt['variabel_id']);
  $p=$this->m_variabel->update_variabel_penduduk_program($where,$array,'tb_variabel_program_sosial');

  for ($i=0; $i<count($dt['sub_id']) ; $i++) {
    $batch[] = array('sub_id'=>$dt['sub_id'][$i],
    'sub_variabel_id'=>$dt['sub_variabel_id'][$i],
    'nama'=>$dt['nama'][$i],
    'skor'=>$dt['skor'][$i]
  );
}
$q=$this->db->update_batch('tb_sub_variabel_program_sosial', $batch, 'sub_id');

redirect('c_variabel/bobot_Penduduk');
}

    /**tabel variabel kategori kecamatan */
    public function VariabelKecamatan(){
        $data['c_variabel'] = $this->m_variabel->varKecamatan()->result();
         $this->load->view('templates/header');
         $this->load->view('admin/inputdata/variabel/kecamatan/v_tabel',$data);
         $this->load->view('templates/footer');
    }

    /**tambah variabel kecamatan */
    function tambah_var_kecamatan(){
        $this->load->view('templates/header');
        $this->load->view('admin/inputdata/variabel/kecamatan/v_tambah1');
        $this->load->view('templates/footer');
    }

    /**insert tambah kategori kecamatan */
function insert_var_kecamatan(){
    $this->load->model('m_variabel');

    $nama_variabel = $this->input->post('nama_variabel');
    // $jenis_io = $this->input->post('jenis_io');

    $dt=$this->input->post();
    $nama = $this->input->post('nama');
    $urutan = $this->input->post('urutan');
    $a = $this->input->post('a');
    $b = $this->input->post('b');
    $c = $this->input->post('c');
    $d = $this->input->post('d');
    
    $query = $this->m_variabel->insert_var_kecamatan($nama_variabel); //,$jenis_io
    $variabel_id = $query['max'];
    $i = 0;
    
    foreach($nama as $key) {
         $this->m_variabel->insert_sub_variabel_kecamatan($variabel_id, $key, $urutan[$i],$a[$i],$b[$i],$c[$i],$d[$i]);
         $i++;
     }

     redirect('c_variabel/VariabelKecamatan');
  }

  /**sama dengan yang di atas tapi hanya insert ke satu tabel */
  function insert_var_kecamatan1(){
    $this->load->model('m_variabel');

    $nama_variabel = $this->input->post('nama_variabel');
    $jenis_io = $this->input->post('jenis_io');

    $a = $this->input->post('a');
    $b = $this->input->post('b');
    $c = $this->input->post('c');
    // $d = $this->input->post('d');

    $array = array('nama_variabel' => $nama_variabel , 
            'jenis_io' => $jenis_io ,
            'a' => $a ,
            'b' => $b ,
            'c' => $c 
            // 'd' => $d
          );
    
    $query = $this->m_variabel->insert_var_kecamatan1($array);

     redirect('c_variabel/VariabelKecamatan');
  }

  public function edit_variabel_kecamatan($id){
    $data['c_variabel'] = $this->m_variabel->edit_variabel_kecamatan($id)->result();
    
     $this->load->view('templates/header');
     $this->load->view('admin/inputdata/variabel/kecamatan/v_edit',$data); //
     $this->load->view('templates/footer');
 }
 
  /**update variabel kecamatan */
  function update_var_kecamatan1(){
    $this->load->model('m_variabel');

    $id = $this->input->post('variabel_id');
    $nama_variabel = $this->input->post('nama_variabel');
    // $jenis_io = $this->input->post('jenis_io');

    $a = $this->input->post('a');
    $b = $this->input->post('b');
    $c = $this->input->post('c');
    // $d = $this->input->post('d');

    $array = array('nama_variabel' => $nama_variabel , 
       'a' => $a ,
        'b' => $b ,'c' => $c 
        // ,'d' => $d
    ); // 'jenis_io' => $jenis_io 
    $where=array('variabel_id'=> $id);

    
    $this->m_variabel->update_var_kecamatan1($where,$array,'tb_variabel_kecamatan');

    //  redirect('c_variabel/VariabelKecamatan');
    redirect('c_variabel/update_nilai_variabel_ke_persen');
  }

  /**update nilai ke persen tb_variabel_kecamatan */
  function update_nilai_variabel_ke_persen(){
    $p=$this->m_variabel->variabel_kemiskinan_kecamatan();
    $p=$this->m_variabel->variabel_ketelantaran_kecamatan();
    $p=$this->m_variabel->variabel_kecacatan_kecamatan();
    $p=$this->m_variabel->variabel_kesejahteraan_kecamatan();
    
    redirect('c_variabel/VariabelKecamatan');
  }


    /**tabel variabel kategori desa */
    public function VariabelDesa(){
        $data['c_variabel'] = $this->m_variabel->varDesa()->result_array();
         $this->load->view('templates/header');
         $this->load->view('admin/inputdata/variabel/desa/v_tabel',$data);
         $this->load->view('templates/footer');
    }

    /**tambah variabel desa */
    function tambah_var_desa(){
        $this->load->view('templates/header');
        $this->load->view('admin/inputdata/variabel/desa/v_tambah');
        $this->load->view('templates/footer');
    }

    /**insert tambah kategori desa */
    function insert_var_desa(){
        $this->load->model('m_variabel');

        $nama_variabel = $this->input->post('nama_variabel');
        $jenis_io = $this->input->post('jenis_io');
        $a = $this->input->post('a');
        $b = $this->input->post('b');
        $c = $this->input->post('c');
        $d = $this->input->post('d');

        $nama = $this->input->post('nama');
        $skor = $this->input->post('skor');

        $query = $this->m_variabel->insert_var_desa($nama_variabel,$jenis_io,$a,$b,$c,$d);
        $variabel_id = $query['max'];
        $i = 0;
        
        foreach($nama as $key) {
            $this->m_variabel->insert_sub_variabel_desa($variabel_id, $key, $skor[$i]);
            $i++;
        }
        redirect('c_variabel/VariabelDesa');
  }

  public function edit_variabel_desa(){
    $data['c_variabel'] = $this->m_variabel->edit_variabel_desa()->result();
    
     $this->load->view('templates/header');
     $this->load->view('admin/inputdata/variabel/desa/v_edit',$data); //
     $this->load->view('templates/footer');
 }
 
  /**update variabel desa */
  function update_var_desa1(){
    $this->load->model('mamdani');

    $id = $this->input->post('variabel_id');
    $nama_variabel = $this->input->post('nama_variabel');
    // $jenis_io = $this->input->post('jenis_io');

    $a = $this->input->post('a');
    $b = $this->input->post('b');
    $c = $this->input->post('c');
    $d = $this->input->post('d');

    $array = array('nama_variabel' => $nama_variabel , 
        'a' => $a ,
        'b' => $b ,'c' => $c ,'d' => $d
    ); //'jenis_io' => $jenis_io ,
    $where=array('variabel_id'=> $id);

    
    $this->m_variabel->update_var_desa1($where,$array,'tb_variabel_desa');

    redirect('c_variabel/update_nilai_variabel_ke_persen_desa');
  }

    /**update nilai ke persen tb_variabel_desa */
    function update_nilai_variabel_ke_persen_desa(){
        $p=$this->m_variabel->variabel_kemiskinan_desa();
        $p=$this->m_variabel->variabel_ketelantaran_desa();
        $p=$this->m_variabel->variabel_kecacatan_desa();
        
        redirect('c_variabel/VariabelDesa');
      }
    


     /**Percobaan input data di c_variabel */
     
     function update()
{
  $data = array(
   $this->input->post('table_column') => $this->input->post('value')
  );

  $this->m_variabel->update($data, $this->input->post('sub_id'));
}

function delete()
{
  $this->m_variabel->delete($this->input->post('sub_id'));
  redirect('c_variabel/VariabelDesa');
}
     /**end Percobaan input data di c_variabel */

/**tambah kedalam 2 tabel dalam 1 inputan tidak dipakai --------------------------------------------------------------------------------------------------*/
    function tambahvariabel(){
        $nama_variabel=$this->input->post('nama_variabel');
        $jenis_io=$this->input->post('jenis_io');

      //   $dt= $this->input->post();
      
      //   for ($i=0; $i<count($dt['sub_id']) ; $i++) { 
      //       $array2[] = array('sub_id'=>$dt['sub_id'][$i],'variabel_id'=>$dt['variabel_id']
    
      // );
      //   }

        $jenis_kurva=$this->input->post('jenis_kurva');
        $nama=$this->input->post('nama');
        $urutan=$this->input->post('urutan');
        $a=$this->input->post('a');
        $b=$this->input->post('b');
        $c=$this->input->post('c');
        $d=$this->input->post('d');

        $array1 = array('nama_variabel' => $nama_variabel,
            'jenis_io'=>$jenis_io);

        $array2 = array('jenis_kurva' => $jenis_kurva , 
            'nama' => $nama ,
            'urutan' => $urutan ,
            'a' => $a ,
            'b' => $b ,
            'c' => $c ,
            'd' => $d);

        $this->m_variabel->input_variabel($array1,$array2);
        redirect('c_variabel/tambah_variabel');
    }


     //update batch
    public function UpdateVaribaelKecamatan(){
        $dt= $this->input->post();
     
       for ($i=0; $i<count($dt['variabel_id']) ; $i++) { 
           $batch[] = array('variabel_id'=>$dt['variabel_id'][$i],'a' => $dt['a'][$i],
            'b' => $dt['b'][$i],
            'c' => $dt['c'][$i],
            'd' => $dt['d'][$i]
   
     );
       }

   //   var_dump($data);
   //   exit;
   $this->db->update_batch('tb_variabel_kecamatan', $batch, 'variabel_id');
      $this->session->set_flashdata('pesan','Nilai Variabel Kecamatan Berhasil Diupdate!');
      redirect('c_variabel/VariabelKecamatan');
   
    }

/**END tidak dipakai-------------------------------------------------------------------------------------------------- */
/**-------------------------------------------PEMBOBOTAN */
function pembobotan_penduduk(){
  $this->m_variabel->pembobotan_penduduk();
}
/**--------------------------------------------------END PEMBOBOTAN */
   

function ubah_bobot(){
  $data['c_variabel']=$this->m_variabel->pembobotan_penduduk();
  $this->load->view('templates/header');
  $this->load->view('admin/inputdata/variabel/penduduk/input_bobot',$data);
  $this->load->view('templates/footer');
}

function update_bobot_penduduk(){
  $dt= $this->input->post();
     
       for ($i=0; $i<count($dt['id']) ; $i++) { 
           $batch[] = array('id'=>$dt['id'][$i],
          //  'nama' => $dt['nama'][$i],
            'bobot' => $dt['bobot'][$i]
   
     );
       }

   //   var_dump($data);
   //   exit;
   $this->db->update_batch('tb_bobot_penduduk', $batch, 'id');
   $this->m_variabel->update_persen();
      $this->session->set_flashdata('pesan','Nilai Kriteria Berhasil Diupdate!');
      
      redirect('c_variabel/bobot_Penduduk');
}

function varPenduduk(){
  $dt= $this->input->post();
     
  for ($i=0; $i<count($dt['id']) ; $i++) { 
      $batch[] = array('id'=>$dt['id'][$i],'nama' => $dt['nama'][$i],
       'min' => $dt['min'][$i],'max' => $dt['max'][$i]

);
  }

//   var_dump($data);
//   exit;
$this->db->update_batch('tb_tingkat_kesejahteraan', $batch, 'id');
$this->m_variabel->update_persen();
 $this->session->set_flashdata('pesan','Nilai Range Berhasil Diupdate!');
 
 redirect('c_variabel/bobot_Penduduk');
}

function varDesa(){
  $dt= $this->input->post();
     
  for ($i=0; $i<count($dt['variabel_id']) ; $i++) { 
      $batch[] = array('variabel_id'=>$dt['variabel_id'][$i],
       'min' => $dt['min'][$i]
       //,'nama_variabel' => $dt['nama_variabel'][$i],'max' => $dt['max'][$i]

);
  }
$this->db->update_batch('tb_variabel_desa', $batch, 'variabel_id');
$this->m_variabel->update_persen_kelurahan();
 $this->session->set_flashdata('pesan','Nilai Range Berhasil Diupdate!');
 
 redirect('c_variabel/VariabelDesa');
}



}

?>
