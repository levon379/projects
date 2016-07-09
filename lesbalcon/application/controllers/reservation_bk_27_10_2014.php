<?php
ob_start();
class reservation extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('public_init_elements');
		$this->public_init_elements->init_elements();
		$this->load->model('language_model');
		$this->load->model('reservation_model');
    }

    function index()
	{ 
		$this->data = array();
		$this->data['properties_arr'] = $this->reservation_model->get_properties();
		$this->data['bungalows_arr'] = $this->reservation_model->get_bungalows();
		$this->data['head'] = $this->load->view('elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('elements/header_top', $this->data, true);
		$this->data['header_menu'] = $this->load->view('elements/header_menu', $this->data, true);
		$this->data['content'] = $this->load->view('maincontents/reservation', $this->data, true);
		$this->data['footer'] = $this->load->view('elements/footer', $this->data, true);
		$this->load->view('layout', $this->data);
    }

	function ajax_get_options()
	{
		$bungalow_id=$_POST['bungalow_id'];
		$result=$this->reservation_model->ajax_get_options($bungalow_id);
		?>
		<div class="col-md-3">
			<label>Options  </label>
		  </div>

		  <?php
		  $out_put="";
		  $x=1;
		  $z=1;
		  $m=1;
		  foreach($result as $options)
		  {
				if($x==$z){ $out_put .= '<div class="col-md-7">'; $z+=3;}
				$out_put .='<div class="col-md-4"> <input id="options" name="options[]" type="checkbox" value="'.$options['options_id']. '">&nbsp;'.$options['options_name'].'</div>';
				if($m%3==0){ $out_put .= '</div>'; }
				$x++;
				$m++;
		  }
		  echo  $out_put;
	}
	
	
	//function to check availability
	function ajax_check_availability()
	{
		$bungalow_id=$_POST['bungalow_id'];
		$arrival_date=$_POST['arrival_date'];
		$leave_date=$_POST['leave_date'];
		$result=$this->reservation_model->ajax_check_availability($bungalow_id, $arrival_date, $leave_date);
		if($result=="available")
		{
			echo "available";
		}
		elseif($result=="notavailable")
		{
			echo "notavailable";
		}
		else
		{
			$imploded_result=implode("^", $result);
			echo $imploded_result;
		}
	}
}

