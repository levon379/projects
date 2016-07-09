<?php
ob_start();
class payment extends CI_Controller
{
    //var $data;
    function  __construct() 
	{
        parent::__construct();
		$this->load->library('admin_init_elements');
		$this->admin_init_elements->init_elements();
		$this->admin_init_elements->is_admin_logged_in();
		$this->load->model("reservation_model");
		$this->load->model('payment_model');
		$this->load->model('users_model');
		$this->load->model('language_model');
		$this->load->model("home_model");
    }

	//Function for list whole payment
    function all()
	{ 
        $this->data = array();
		$this->data['all_rows'] = $this->payment_model->get_payment();
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/payment_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
    }
	
	//Function for getting partial Payment
	function partial()
	{
		$this->data = array();
		$this->data['all_rows'] = $this->payment_model->get_payment("partial");
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/payment_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}	
	
	//Function for getting completed Payment
	function confirm()
	{
		$this->data = array();
		$this->data['all_rows'] = $this->payment_model->get_payment("confirm");
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/payment_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//Function for getting completed Payment
	function paid()
	{
		$this->data = array();
		$this->data['all_rows'] = $this->payment_model->get_payment("paid");
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/payment_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//Function for getting completed Payment
	function cancelled()
	{
		$this->data = array();
		$this->data['all_rows'] = $this->payment_model->get_payment("cancelled");
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/payment_list', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	//Function to view details
	function viewdetails($payment_id)
	{
		$this->data = array();
		$this->data['payment_details'] = $this->payment_model->get_payment_details($payment_id);
		/* echo "<pre>";
		print_r($this->data);die; */
		//Loading All Pages Part Sequentially
        $this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/payment_details_view', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	
	
	
	//Function to change reservation status
	function ajax_change_reservation_status()
	{
		$id=$_POST['id'];
		$status=$_POST['status'];
		$result=$this->payment_model->ajax_change_reservation_status($id, $status);
	}
	
	//Function to change payment status
	function ajax_change_amount()
	{
		$id=$_POST['id'];
		$invoice_comments=$_POST['invoice_comments'];
		$admin_comments=$_POST['admin_comments'];
		$paid_amount=str_replace("€", "", $_POST['paid_amount']);
		$due_amount=str_replace("€", "", $_POST['due_amount']);
		$pay_amount=str_replace("€", "", $_POST['pay_amount']);
		$payment_mode = $_POST["payment_mode"];
		$date_payment_mode = $_POST["date_payment_mode"];
		
		$result=$this->payment_model->ajax_change_amount($id, $paid_amount,$due_amount,$pay_amount, $payment_mode,$date_payment_mode,$admin_comments,$invoice_comments);
	}

	
	//Function to change payment status
	function ajax_edit_amount()
	{
		$id=$_POST['id'];
		$txt_discount=$_POST['txt_discount'];
		$txt_total=str_replace("€", "", $_POST['txt_total']);
		$txt_paid_amount=str_replace("€", "", $_POST['txt_paid_amount']);
		$txt_due_amount=str_replace("€", "", $_POST['txt_due_amount']);

		$admin_comments=$_POST['admin_comments'];
		$invoice_comments=$_POST['invoice_comments'];
		$source=$_POST['source'];

		$result=$this->payment_model->ajax_edit_amount($id, $txt_discount,$txt_total,$txt_paid_amount,$txt_due_amount,$admin_comments,$invoice_comments,$source);
	}
	function ajax_payment()
	{
		$id=$_POST['id'];
		$payment_mode = $_POST["payment_mode"];
		$date_payment_mode = $_POST["date_payment_mode"];
		$result=$this->payment_model->ajax_payment($id, $payment_mode,$date_payment_mode);
	}
	
	//Function to change payment status
	function ajax_change_payment_status()
	{
		$id=$_POST['id'];
		$status=$_POST['status'];
		$result=$this->payment_model->ajax_change_payment_status($id, $status);
	}
	
	//Function to change active status
	function ajax_change_active_inactive()
	{
		$id=$_POST['id'];
		$status=$_POST['status'];
		$result=$this->payment_model->ajax_change_active_inactive($id, $status);
	}
	
	//Function to delete payment
	function ajax_delete_payment()
	{
		$id=$_POST['id'];
		$status=$_POST['status'];
		$result=$this->payment_model->ajax_delete_payment($id);
	}
	
	
	//Function to increase leave date
	function ajax_increase_leave_date()
	{
		$reservation_id=$_POST['reservation_id'];
		
		$current_leave_date_arr=explode("/", $_POST['current_leave_date']);
		$current_leave_date=$current_leave_date_arr[2]."-".$current_leave_date_arr[1]."-".$current_leave_date_arr[0];
		//Checking availability will be from next date because current leave date is reserved.
		$start_date=date("Y-m-d", strtotime('+1 day', strtotime($current_leave_date)));
		$leave_date_arr=explode("/", $_POST['leave_date']);
		$leave_date=$leave_date_arr[2]."-".$leave_date_arr[1]."-".$leave_date_arr[0];
		$result=$this->payment_model->ajax_increase_leave_date($reservation_id, $start_date, $leave_date);
		echo $result;
	}
	
	//function to download as excel
	function download_as_excel($payment_type)
	{
		if($payment_type=="all")
		{
			$payment_arr=$this->payment_model->get_payment();
			$payment_type_text="All";
		}
		elseif($payment_type=="partial")
		{
			$payment_arr=$this->payment_model->get_payment("partial");
			$payment_type_text="Partial";
		}
		elseif($payment_type=="Activer")
		{
			$payment_arr=$this->payment_model->get_payment("Activer");
			$payment_type_text="Ativer";
		}
		elseif($payment_type=="Desactiver")
		{
			$payment_arr=$this->payment_model->get_payment("Desactiver");
			$payment_type_text="Desactiver";
		}
		elseif($payment_type=="Réglé")
		{
			$payment_arr=$this->payment_model->get_payment("Réglé");
			$payment_type_text="Réglé";
		}
		elseif($payment_type=="Annulé")
		{
			$payment_arr=$this->payment_model->get_payment("Annulé");
			$payment_type_text="Annulé";
		}
                elseif($payment_type=="confirm")
		{
			$payment_arr=$this->payment_model->get_payment("confirm");
			$payment_type_text="confirm";
		}
		$this->load->library('excel');
		PHPExcel_Shared_File::setUseUploadTempDirectory(true);//it is for set permission as true
		$this->excel->setActiveSheetIndex(0);
		//Configure Worksheet Heading
		$this->excel->getActiveSheet()->setTitle('Payment Worksheet');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$this->excel->getActiveSheet()->setCellValue('A1', 'Reservation/Payment [ '.$payment_type_text.' ]');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A1:G1');
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		//Configure Row Heading
		$this->excel->getActiveSheet()->setCellValue('A2', 'RESERVATION DATE');
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('B2', 'BUNGALOW NAME');
		$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('C2', 'ARRIVAL DATE');
		$this->excel->getActiveSheet()->getStyle('C2')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('D2', 'LEAVE DATE');
		$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('E2', 'RESERVATION STATUS');
		$this->excel->getActiveSheet()->getStyle('E2')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('F2', 'PAYMENT STATUS');
		$this->excel->getActiveSheet()->getStyle('F2')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->setCellValue('G2', 'PAID AMOUNT');
		$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->setCellValue('H2', 'IS ACTIVE');
		$this->excel->getActiveSheet()->getStyle('H2')->getFont()->setSize(10);
		$this->excel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
                //Configure Row Data
		$row=3;
		foreach($payment_arr as $payment)
		{
			$arrival_date=($payment['arrival_date']!='')?date("d/m/Y", strtotime($payment['arrival_date'])):'';
			$leave_date=($payment['leave_date']!='')?date("d/m/Y", strtotime($payment['leave_date'])):'';
			$reservation_date=($payment['reservation_date']!='')?date("d/m/Y H:i:s", strtotime($payment['reservation_date'])):' TOTAL ';
                    
			$this->excel->getActiveSheet()->setCellValue('A'.$row, $reservation_date);
			$this->excel->getActiveSheet()->setCellValue('B'.$row, $payment['bunglow_name']);
			$this->excel->getActiveSheet()->setCellValue('C'.$row, $arrival_date);
			$this->excel->getActiveSheet()->setCellValue('D'.$row, $leave_date);
			$this->excel->getActiveSheet()->setCellValue('E'.$row, $payment['reservation_status']);
			$this->excel->getActiveSheet()->setCellValue('F'.$row, $payment['payment_status']);
			$this->excel->getActiveSheet()->setCellValue('G'.$row, $payment['paid_amount']);
                        $this->excel->getActiveSheet()->setCellValue('H'.$row, $payment['is_active']);
			$row++;
		}
		$filename='Payment_list_'.date("d_m_Y").'.xls'; 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$filename.'"'); 
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save('php://output');
	}
	//function to edit reservation
	function payment_edit($reservation_id)
	{
		
		$reservation_details=$this->home_model->get_reservation_details($reservation_id);
		$options_ids=array();
		if(!empty($reservation_details[0]['options_id']))
		{
			$options_ids=explode(",",$reservation_details[0]['options_id']);
		}
		$arrival_date_array	=explode("-", $reservation_details[0]['arrival_date']);
		$arrival_date		=$arrival_date_array[2]."/".$arrival_date_array[1]."/".$arrival_date_array[0];
		$leave_date_array	=explode("-", $reservation_details[0]['leave_date']);
		$leave_date			=$leave_date_array[2]."/".$leave_date_array[1]."/".$leave_date_array[0];
		$source				=$reservation_details[0]['source'];
		$users_list			=$this->home_model->get_all_users();
		$bungalow_details	=$this->home_model->get_bungalow_details($reservation_details[0]['bunglow_id']);
		$bungalow_options_details=$this->home_model->get_options_details($reservation_details[0]['bunglow_id']);
		$linked_reservation_details=$this->home_model->get_linked_reservations($reservation_id);
		$reservation_user_details=$this->home_model->get_user_details($reservation_details[0]['user_id']);
		
		
		

		
		if( strstr($_SERVER["QUERY_STRING"],"res_id")){
			$part = explode("=", $_SERVER["QUERY_STRING"]);
			$this->users_model->download_invoice( $part[1] );
		}

		if ($this->input->post('save'))
		{
			$vatdate=$this->input->post('arrival_date');
			$timestamp = strtotime(str_replace('/', '-', $vatdate));
			$datefinale_mois=date("m", $timestamp);
			$datefinale_annee=date("Y", $timestamp);
			$arrayfr=array("01"=>"Janvier","02"=>"Fevrier","03"=>"Mars","04"=>"Avril","05"=>"Mai","06"=>"Juin","07"=>"Juillet","08"=>"Aout","09"=>"Septembre","10"=>"Octobre","11"=>"Novembre","12"=>"Decembre");
				
			
			if($this->input->post('cur_bungalow_id')==$this->input->post('bungalow_id') && $this->input->post('arrival_date') == $this->input->post('hid_arrival_date') && $this->input->post('leave_date') == $this->input->post('hid_leave_date')){
				$result=$this->home_model->edit_reservation();		
				//yrcode
				if($result=="notavailable")
					redirect("admin/payment/payment_edit/".$reservation_id."?no");
				else
					redirect("admin/home/?".$arrayfr[$datefinale_mois]."_".$datefinale_annee."-".$datefinale_mois);	
				//end yrcode	
				//redirect("admin/home?editsuccess");		
			}
			else{
				//$response = $this->ajax_check_availability($reservation_details[0]['bunglow_id'],$this->input->post('arrival_date'),$this->input->post('leave_date'),$reservation_id);
				$response = $this->ajax_check_availability($this->input->post('bungalow_id'),$this->input->post('arrival_date'),$this->input->post('leave_date'),$reservation_id);
				if($response == 'yes'){
					$result=$this->home_model->edit_reservation();
					redirect("admin/home/?".$arrayfr[$datefinale_mois]."_".$datefinale_annee."-".$datefinale_mois.'&editsuccess=1');	
				}else if($response == 'no'){
					redirect("admin/payment/payment_edit/".$reservation_id."?no");
				}else if($response == 'partial'){
					redirect("admin/payment/payment_edit/".$reservation_id."?partial");
				}
			}
				
		} 
		
		$this->data['totalAmountCalcul'] = $this->reservation_model->getAmountTotal($reservation_details);
		$this->data['reservation_id']		=$reservation_id;
		$this->data['reservation_details']	=$reservation_details;
		$this->data['dueamount']	= $this->reservation_model->getDueAmount($this->data['totalAmountCalcul'],$reservation_details[0]['paid_amount']);
		$this->data['linked_reservation_details']	=$linked_reservation_details; 
		$this->data['options_ids']			=$options_ids;
		$this->data['arrival_date']			=$arrival_date;
		$this->data['leave_date']			=$leave_date;
		$this->data['source']				=$source;
		$this->data['users_list']			=$users_list;
		$this->data['bungalow_details']		=$bungalow_details;
		$this->data['bungalow_options_details']=$bungalow_options_details;
		$this->data['reservation_user_details']=$reservation_user_details;
		$this->data['head'] = $this->load->view('admin/elements/head', $this->data, true);
		$this->data['header_top'] = $this->load->view('admin/elements/header_top', $this->data, true);
		$this->data['left_side_bar'] = $this->load->view('admin/elements/left_side_bar', $this->data, true);
		$this->data['content'] = $this->load->view('admin/maincontents/payment_edit', $this->data, true);
		$this->data['footer'] = $this->load->view('admin/elements/footer', $this->data, true);
		$this->load->view('admin/layout_home', $this->data);
	}
	//function to check availability
	function ajax_check_availability($bungalow_id,$posted_arrival_date,$posted_leave_date,$reservation_id=''){		
		$arrival_date_arr=explode("/", $posted_arrival_date);
		$arrival_date = mktime(0,0,0, $arrival_date_arr[1], $arrival_date_arr[0], $arrival_date_arr[2] );
		$leave_date_arr = explode("/", $posted_leave_date);
		$leave_date=mktime(0,0,0, $leave_date_arr[1], $leave_date_arr[0]-1, $leave_date_arr[2] );
		$result=$this->reservation_model->ajax_check_availability($bungalow_id,  $arrival_date, $leave_date,$reservation_id);

		if($result=="available"){
			$price_data = $this->reservation_model->get_bungalows_price($bungalow_id, $posted_arrival_date, $posted_leave_date);
			
			if( !empty($price_data) && !empty( $price_data['total_euro'] ) ){
				$res = 'yes';
			}else {
				$res = 'no';
			}
		}elseif($result=="notavailable"){
			$res = 'no';
		}else{
			$res = 'partial';
		}
		return $res;	
	}
}