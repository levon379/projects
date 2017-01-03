<?php
ini_set('zlib.output_compression', 'Off');
class Admin_report extends MX_Controller {

    public function _this() {
        $this->index();
    }

    public function index() {
        echo 'will be report table';
    }

    public function read() 
    {
        $this->load->model('statistic_model');
        $user_info = $this->statistic_model->get_users_report();
        $this->mysmarty->assign('action', 'read');
        $this->mysmarty->assign('user_info', $user_info);
        $this->mysmarty->view('admin_report');
    }

    public function this_week_registrations()
    {
        $this->load->model('statistic_model');
        $user_info = $this->statistic_model->get_this_week_registered_users_report();
        $this->mysmarty->assign('action', 'this_week_registrations');
        $this->mysmarty->assign('user_info', $user_info);
        $this->mysmarty->view('admin_report');
    }

    public function this_week_all_users()
    {
        $this->load->model('statistic_model');
        $user_info = $this->statistic_model->get_this_week_all_users_report();
        $this->mysmarty->assign('action', 'this_week_all_users');
        $this->mysmarty->assign('user_info', $user_info);
        $this->mysmarty->view('admin_report');
    }
    
    public function by_asset()
    {
        $this->load->model('statistic_model');
        $asset_info = $this->statistic_model->get_assets_report();
        $this->mysmarty->assign('action', 'by_asset');
        $this->mysmarty->assign('asset_info', $asset_info);
        $this->mysmarty->view('admin_report');
    }
    
    public function by_strategies()
    {
        $this->load->model('statistic_model');
        $strategy_info = $this->statistic_model->get_strategy_report();
        $this->mysmarty->assign('action', 'by_strategies');
        $this->mysmarty->assign('strategy_info', $strategy_info);
        $this->mysmarty->view('admin_report');
    }
    
    public function by_expire()
    {
        $this->load->model('statistic_model');
        $expire_info = $this->statistic_model->get_expire_report();
        $this->mysmarty->assign('action', 'by_expire');
        $this->mysmarty->assign('expire_info', $expire_info);
        $this->mysmarty->view('admin_report');
    }
    
    public function by_asset_expire()
    {
        $this->load->model('statistic_model');
        $asset_expire_info = $this->statistic_model->get_asset_expire_report();
        $this->mysmarty->assign('action', 'by_asset_expire');
        $this->mysmarty->assign('asset_expire_info', $asset_expire_info);
        $this->mysmarty->view('admin_report');
    }
    
    public function export_by_expire()
    {
        $this->load->library("pxl");
        $this->load->library('pxl/PHPExcel/IOFactory');
        $objPHPExcel = new PHPExcel();
        
        $this->load->model('statistic_model');
        $expire_info = $this->statistic_model->get_expire_report();
        
        for ($i = 0; $i < count($expire_info); $i++) {
            if ($expire_info[$i]['winning_rates'] != 0) {
                $expire_info[$i]['winning_rates'] = $expire_info[$i]['winning_rates'] . '%';
            }
            if ($expire_info[$i]['loosing_rates'] != 0) {
                $expire_info[$i]['loosing_rates'] = $expire_info[$i]['loosing_rates'] . '%';
            }
        }
        
        
        $base_font = array(
            'font' => array(
                'name' => 'Calibri',
                'size' => '10',
                'bold' => false
            )
        );
        $bold_font = array(
            'font' => array(
                'name' => 'Calibri',
                'size' => '10',
                'bold' => true
            )
        );
        $align = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
            )
        );
        
        $table_header = array('Expire Name', 'Open Trades', 'Closed Trades', 'Winning Ratio', 'Loosing Ratio');
        $objPHPExcel->getProperties()->setTitle("Statistics")->setDescription("Statistics by list of Expires");
        
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
            
        $sheet->getStyle('A1:E1')->applyFromArray($bold_font);
        $sheet->getStyle('A1:E1')->applyFromArray($align);
        $sheet->fromArray($table_header, null, 'A1');
        $sheet->getStyle('A:E')->applyFromArray($base_font);
        $sheet->getStyle('A:E')->applyFromArray($align);
        
        $sheet->fromArray($expire_info, null, 'A2');
        
        $objWriter = IOFactory::createWriter($objPHPExcel, "Excel5");
        //this one generates Notice, comment
//        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="export_by_expire.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit();
    }

    public function export_this_week_registrations()
    {
        $this->load->library("pxl");
        $this->load->library('pxl/PHPExcel/IOFactory');
        $objPHPExcel = new PHPExcel();

        $this->load->model('statistic_model');
        $expire_info = $this->statistic_model->get_this_week_registered_users_report();

        for ($i = 0; $i < count($expire_info); $i++) {
            unset($expire_info[$i]['user_id']);
            if ($expire_info[$i]['winn_rate'] != 0) {
                $expire_info[$i]['winn_rate'] = $expire_info[$i]['winn_rate'] . '%';
            }
            if ($expire_info[$i]['loose_rate'] != 0) {
                $expire_info[$i]['loose_rate'] = $expire_info[$i]['loose_rate'] . '%';
            }
        }


        $base_font = array(
            'font' => array(
                'name' => 'Calibri',
                'size' => '10',
                'bold' => false
            )
        );
        $bold_font = array(
            'font' => array(
                'name' => 'Calibri',
                'size' => '10',
                'bold' => true
            )
        );
        $align = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
            )
        );

        $table_header = array('User', 'Email', 'Country', 'Open Trades', 'Closed Trades', 'Total of Shares', 'Winning Ratio', 'Losing Ratio', 'Last Logged', 'How many times logged in', 'Logged Last month');
        $objPHPExcel->getProperties()->setTitle("Statistics")->setDescription("Statistics by list of Expires");

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);

        $sheet->getStyle('A1:K1')->applyFromArray($bold_font);
        $sheet->getStyle('A1:K1')->applyFromArray($align);
        $sheet->fromArray($table_header, null, 'A1');
        $sheet->getStyle('A:K')->applyFromArray($base_font);
        $sheet->getStyle('A:K')->applyFromArray($align);


        $sheet->fromArray($expire_info, null, 'A2');

        $objWriter = IOFactory::createWriter($objPHPExcel, "Excel5");
        //this one generates Notice, comment
//        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="export_by_users.xls"');
        header('Cache-Control: max-age=0');
        $this->session->unset_userdata('file_name');
        $objWriter->save('php://output');
        ob_end_flush();
        exit();
    }

    public function export_this_week_all_users()
    {
        $this->load->library("pxl");
        $this->load->library('pxl/PHPExcel/IOFactory');
        $objPHPExcel = new PHPExcel();

        $this->load->model('statistic_model');
        $expire_info = $this->statistic_model->get_this_week_all_users_report();

        for ($i = 0; $i < count($expire_info); $i++) {
            if ($expire_info[$i]['winn_rate'] != 0) {
                $expire_info[$i]['winn_rate'] = $expire_info[$i]['winn_rate'] . '%';
            }
            if ($expire_info[$i]['loose_rate'] != 0) {
                $expire_info[$i]['loose_rate'] = $expire_info[$i]['loose_rate'] . '%';
            }
        }


        $base_font = array(
            'font' => array(
                'name' => 'Calibri',
                'size' => '10',
                'bold' => false
            )
        );
        $bold_font = array(
            'font' => array(
                'name' => 'Calibri',
                'size' => '10',
                'bold' => true
            )
        );
        $align = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
            )
        );

        $table_header = array('User', 'Email', 'Country', 'Open Trades', 'Closed Trades', 'Total of Shares', 'Winning Ratio', 'Losing Ratio', 'Last Logged', 'How many times logged in', 'Logged Last month');
        $objPHPExcel->getProperties()->setTitle("Statistics")->setDescription("Statistics by list of Expires");

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);

        $sheet->getStyle('A1:K1')->applyFromArray($bold_font);
        $sheet->getStyle('A1:K1')->applyFromArray($align);
        $sheet->fromArray($table_header, null, 'A1');
        $sheet->getStyle('A:K')->applyFromArray($base_font);
        $sheet->getStyle('A:K')->applyFromArray($align);


        $sheet->fromArray($expire_info, null, 'A2');

        $objWriter = IOFactory::createWriter($objPHPExcel, "Excel5");
        //this one generates Notice, comment
//        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="export_by_users.xls"');
        header('Cache-Control: max-age=0');
        $this->session->unset_userdata('file_name');
        $objWriter->save('php://output');
        ob_end_flush();
        exit();
    }

    public function export_by_read()
    {
        $this->load->library("pxl");
        $this->load->library('pxl/PHPExcel/IOFactory');
        $objPHPExcel = new PHPExcel();
        
        $this->load->model('statistic_model');
        $expire_info = $this->statistic_model->get_users_report();
        
        for ($i = 0; $i < count($expire_info); $i++) {
            if ($expire_info[$i]['winn_rate'] != 0) {
                $expire_info[$i]['winn_rate'] = $expire_info[$i]['winn_rate'] . '%';
            }
            if ($expire_info[$i]['loose_rate'] != 0) {
                $expire_info[$i]['loose_rate'] = $expire_info[$i]['loose_rate'] . '%';
            }
        }
        
        
        $base_font = array(
            'font' => array(
                'name' => 'Calibri',
                'size' => '10',
                'bold' => false
            )
        );
        $bold_font = array(
            'font' => array(
                'name' => 'Calibri',
                'size' => '10',
                'bold' => true
            )
        );
        $align = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
            )
        );
        
        $table_header = array('User', 'Email', 'Country', 'Open Trades', 'Closed Trades', 'Total of Shares', 'Winning Ratio', 'Losing Ratio', 'Last Logged', 'How many times logged in', 'Logged Last month');
        $objPHPExcel->getProperties()->setTitle("Statistics")->setDescription("Statistics by list of Expires");
        
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
            
        $sheet->getStyle('A1:K1')->applyFromArray($bold_font);
        $sheet->getStyle('A1:K1')->applyFromArray($align);
        $sheet->fromArray($table_header, null, 'A1');
        $sheet->getStyle('A:K')->applyFromArray($base_font);
        $sheet->getStyle('A:K')->applyFromArray($align);
        
        
        $sheet->fromArray($expire_info, null, 'A2');
        
        $objWriter = IOFactory::createWriter($objPHPExcel, "Excel5");
        //this one generates Notice, comment
//        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="export_by_users.xls"');
        header('Cache-Control: max-age=0');
        $this->session->unset_userdata('file_name');
        $objWriter->save('php://output');
        ob_end_flush();
        exit();
    }
    
    public function export_by_asset()
    {
        $this->load->library("pxl");
        $this->load->library('pxl/PHPExcel/IOFactory');
        $objPHPExcel = new PHPExcel();
        
        $this->load->model('statistic_model');
        $expire_info = $this->statistic_model->get_assets_report();
        
        for ($i = 0; $i < count($expire_info); $i++) {
            if ($expire_info[$i]['winning_rate'] != 0) {
                $expire_info[$i]['winning_rate'] = $expire_info[$i]['winning_rate'] . '%';
            }
            if ($expire_info[$i]['loosing_rate'] != 0) {
                $expire_info[$i]['loosing_rate'] = $expire_info[$i]['loosing_rate'] . '%';
            }
        }
        
        
        $base_font = array(
            'font' => array(
                'name' => 'Calibri',
                'size' => '10',
                'bold' => false
            )
        );
        $bold_font = array(
            'font' => array(
                'name' => 'Calibri',
                'size' => '10',
                'bold' => true
            )
        );
        $align = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
            )
        );
        
        $table_header = array('Asset', 'Open Trades', 'Closed Trades', 'Winning Ratio', 'Losing Ratio');
        $objPHPExcel->getProperties()->setTitle("Statistics")->setDescription("Statistics by list of Expires");
        
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
            
        $sheet->getStyle('A1:E1')->applyFromArray($bold_font);
        $sheet->getStyle('A1:E1')->applyFromArray($align);
        $sheet->fromArray($table_header, null, 'A1');
        $sheet->getStyle('A:E')->applyFromArray($base_font);
        $sheet->getStyle('A:E')->applyFromArray($align);
        
        
        $sheet->fromArray($expire_info, null, 'A2');
        
        $objWriter = IOFactory::createWriter($objPHPExcel, "Excel5");
        //this one generates Notice, comment
//        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="export_by_asset.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit();
    }
    
    public function export_by_strategies()
    {
        $this->load->library("pxl");
        $this->load->library('pxl/PHPExcel/IOFactory');
        $objPHPExcel = new PHPExcel();
        
        $this->load->model('statistic_model');
        $expire_info = $this->statistic_model->get_strategy_report();
        
        for ($i = 0; $i < count($expire_info); $i++) {
            if ($expire_info[$i]['winning_rates'] != 0) {
                $expire_info[$i]['winning_rates'] = $expire_info[$i]['winning_rates'] . '%';
            }
            if ($expire_info[$i]['loosing_rates'] != 0) {
                $expire_info[$i]['loosing_rates'] = $expire_info[$i]['loosing_rates'] . '%';
            }
        }
        
        
        $base_font = array(
            'font' => array(
                'name' => 'Calibri',
                'size' => '10',
                'bold' => false
            )
        );
        $bold_font = array(
            'font' => array(
                'name' => 'Calibri',
                'size' => '10',
                'bold' => true
            )
        );
        $align = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
            )
        );
        
        $table_header = array('Strategy', 'Open Trades', 'Closed Trades', 'Winning Ratio', 'Losing Ratio');
        $objPHPExcel->getProperties()->setTitle("Statistics")->setDescription("Statistics by list of Expires");
        
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
            
        $sheet->getStyle('A1:E1')->applyFromArray($bold_font);
        $sheet->getStyle('A1:E1')->applyFromArray($align);
        $sheet->fromArray($table_header, null, 'A1');
        $sheet->getStyle('A:E')->applyFromArray($base_font);
        $sheet->getStyle('A:E')->applyFromArray($align);
        
        
        $sheet->fromArray($expire_info, null, 'A2');
        
        $objWriter = IOFactory::createWriter($objPHPExcel, "Excel5");
        //this one generates Notice, comment
//        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="export_by_strategies.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit();
    }
    
    public function export_by_asset_expire()
    {
        $this->load->library("pxl");
        $this->load->library('pxl/PHPExcel/IOFactory');
        $objPHPExcel = new PHPExcel();
        
        $this->load->model('statistic_model');
        $expire_info = $this->statistic_model->get_asset_expire_report();
        
        for ($i = 0; $i < count($expire_info); $i++) {
            if ($expire_info[$i]['60sec'] != 0) {
                $expire_info[$i]['60sec'] = $expire_info[$i]['60sec'] . '%';
            }
            if ($expire_info[$i]['15min'] != 0) {
                $expire_info[$i]['15min'] = $expire_info[$i]['15min'] . '%';
            }
            if ($expire_info[$i]['1h'] != 0) {
                $expire_info[$i]['1h'] = $expire_info[$i]['1h'] . '%';
            }
            if ($expire_info[$i]['4h'] != 0) {
                $expire_info[$i]['4h'] = $expire_info[$i]['4h'] . '%';
            }
            if ($expire_info[$i]['1d'] != 0) {
                $expire_info[$i]['1d'] = $expire_info[$i]['1d'] . '%';
            }
            if ($expire_info[$i]['3d'] != 0) {
                $expire_info[$i]['3d'] = $expire_info[$i]['3d'] . '%';
            }
            if ($expire_info[$i]['1w'] != 0) {
                $expire_info[$i]['1w'] = $expire_info[$i]['1w'] . '%';
            }
            if ($expire_info[$i]['1mon'] != 0) {
                $expire_info[$i]['1mon'] = $expire_info[$i]['1mon'] . '%';
            }
        }
        
        
        $base_font = array(
            'font' => array(
                'name' => 'Calibri',
                'size' => '10',
                'bold' => false
            )
        );
        $bold_font = array(
            'font' => array(
                'name' => 'Calibri',
                'size' => '10',
                'bold' => true
            )
        );
        $align = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
            )
        );
        
        $table_header = array('Assest/expiry', '60 seconds', '15 miutes', '1 hour', '4 hours', '1 day', '3 days', '1 week', '1 month');
        $objPHPExcel->getProperties()->setTitle("Statistics")->setDescription("Statistics by list of Expires");
        
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
            
        $sheet->getStyle('A1:I1')->applyFromArray($bold_font);
        $sheet->getStyle('A1:I1')->applyFromArray($align);
        $sheet->fromArray($table_header, null, 'A1');
        $sheet->getStyle('A:I')->applyFromArray($base_font);
        $sheet->getStyle('A:I')->applyFromArray($align);
        
        
        $sheet->fromArray($expire_info, null, 'A2');
        
        $objWriter = IOFactory::createWriter($objPHPExcel, "Excel5");
        //this one generates Notice, comment
//        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="export_by_asset_expire.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit();
    }

    public function send_weekly_report()
    {
        $date_from = date('Y-m-d', strtotime('last Wednesday'));
        $date_to = date('Y-m-d');
        $new_user_trades_report = $date_from.'-'.$date_to;
        $xls_filename = APPPATH.'cache/reports/'.$new_user_trades_report.'.xls';

        $this->load->library("pxl");
        $this->load->library('pxl/PHPExcel/IOFactory');
        $objPHPExcel = new PHPExcel();

        $data = array();
        $user_ids = array();
        $this->load->model('statistic_model');
        $new_users = $this->statistic_model->get_this_week_registered_users_report();

        $data['new_users_count'] = count($new_users);
        $data['trades_count'] = $this->statistic_model->getCountTradesThisWeekByAllUsers($date_from);
        $data['shares_count'] = $this->statistic_model->getCountPostedThisWeekByAllUsers($date_from);


        for ($i = 0; $i < count($new_users); $i++) {
            $user_ids[] = $new_users[$i]['user_id'];
            unset($new_users[$i]['user_id']);
            if ($new_users[$i]['winn_rate'] != 0) {
                $new_users[$i]['winn_rate'] = $new_users[$i]['winn_rate'] . '%';
            }
            if ($new_users[$i]['loose_rate'] != 0) {
                $new_users[$i]['loose_rate'] = $new_users[$i]['loose_rate'] . '%';
            }
        }
        $data['new_users_trades_count'] = $this->statistic_model->getCountTradesThisWeekByUsers($user_ids, $date_from);

        $base_font = array('font' => array('name' => 'Calibri','size' => '10','bold' => false));
        $bold_font = array('font' => array('name' => 'Calibri','size' => '10','bold' => true));
        $align = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP));

        $table_header = array('User', 'Email', 'Country', 'Open Trades', 'Closed Trades', 'Total of Shares', 'Winning Ratio', 'Losing Ratio', 'Last Logged', 'How many times logged in', 'Logged Last month');
        $objPHPExcel->getProperties()->setTitle("Statistics")->setDescription("Statistics by list of Expires");

        $sheet = $objPHPExcel->getActiveSheet();
//        $sheet->getColumnDimension('A:K')->setAutoSize(true);
        foreach(range('A','K') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $sheet->getStyle('A1:K1')->applyFromArray($bold_font);
        $sheet->getStyle('A1:K1')->applyFromArray($align);
        $sheet->fromArray($table_header, null, 'A1');
        $sheet->getStyle('A:K')->applyFromArray($base_font);
        $sheet->getStyle('A:K')->applyFromArray($align);
        $sheet->fromArray($new_users, null, 'A2');

        $objWriter = IOFactory::createWriter($objPHPExcel, "Excel5");
        $this->session->unset_userdata('file_name');
        $objWriter->save($xls_filename);

        $text = "<h3>Weekly report ".$date_from.' - '.$date_to."</h3><br/>\n";
        $text .= "New users: ".$data['new_users_count']."<br/>\n";
        $text .= "New users trades: ".$data['new_users_trades_count']."<br/>\n";
        $text .= "Total trades: ".$data['trades_count']."<br/>\n";
        $text .= "Total shares: ".$data['shares_count']."<br/>\n";
        $text .= "<br/>\n";
        $text .= "Detailed report (trades of registered users) in attachment. <br/>\n";
        $this->load->library('email');

        $this->email->from('report@binaryoptionsthatsuck.com', 'Report Bot');
        $this->email->to('littfed@gmail.com');

        $this->email->subject("Weekly report ".$date_from.' - '.$date_to);
        $this->email->message($text);
        $this->email->attach($xls_filename);

        $result = $this->email->send();
	var_dump($result);
        echo $this->email->print_debugger();

        var_dump($data);
    }

}
