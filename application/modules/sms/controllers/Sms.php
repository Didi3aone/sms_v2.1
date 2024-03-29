<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends CI_Controller {

    private $_title = "Sms";
    private $_title_page = '<i class="fa-fw fa fa-envelope"></i> Sms ';
    private $_breadcrumb = "<li><a href='".MANAGER_HOME."'>Home</a></li>";
    private $_active_page = "SMS";
    private $_back = "sms";
    private $_js_view = "sms/";
    private $_view_folder = "sms/";

    protected $_header;
    protected $_footer;
    protected $id = 0;
    protected $no_sms = 0;

    public function __construct() {
        parent::__construct();
        if($this->session->userdata(IS_LOGIN_ADMIN) == FALSE) {
            redirect('login');
        }
    }

    /**
    * Function list sms
    * author : didi
    */
    public function index()
    {
        //set header attribute.
        $this->_header = array(
            "title"         => $this->_title,
            "title_page"    => $this->_title_page . '<span>> List Sms </span>',
            "active_page"   => $this->_active_page,
            "breadcrumb"    => $this->_breadcrumb . '<li>Sms </li>',
        );

        //set footer attribute (additional script and css).
        $this->_footer = array(
            "view_js_nav"  => $this->_js_view.'group_js',
            "script"       => array(
                "assets/js/plugins/datatables/jquery.dataTables.min.js",
                "assets/js/plugins/datatables/dataTables.bootstrap.min.js",
                "assets/js/plugins/datatable-responsive/datatables.responsive.min.js",
            )
        );

        //load the views.
        $this->load->view(MANAGER_HEADER , $this->_header);
        $this->load->view($this->_view_folder . 'index');
        $this->load->view(MANAGER_FOOTER , $this->_footer);
    }

    public function inbox()
    {
        // $datas['data'] = $this->getMessage( 67851470 );
        //set header attribute.
        $this->_header = array(
            "title"         => $this->_title,
            "title_page"    => $this->_title_page . '<span>> Inbox List </span>',
            "active_page"   => $this->_active_page.'-INBOX',
            "breadcrumb"    => $this->_breadcrumb . '<li>inbox </li>',
        );

        //set footer attribute (additional script and css).
        $this->_footer = array(
            "view_js_nav"  => $this->_js_view.'inbox_js',
            "script"       => array(
                "assets/js/plugins/datatables/jquery.dataTables.min.js",
                "assets/js/plugins/datatables/dataTables.bootstrap.min.js",
                "assets/js/plugins/datatable-responsive/datatables.responsive.min.js",
            )
        );

        //load the views.
        $this->load->view(MANAGER_HEADER , $this->_header);
        $this->load->view($this->_view_folder . 'inbox');
        $this->load->view(MANAGER_FOOTER , $this->_footer);
    }

    public function outbox()
    {
        //set header attribute.
        $this->_header = array(
            "title"         => $this->_title,
            "title_page"    => $this->_title_page . '<span>> Oubox List </span>',
            "active_page"   => $this->_active_page.'-OUTBOX',
            "breadcrumb"    => $this->_breadcrumb . '<li>outbox </li>',
        );

        //set footer attribute (additional script and css).
        $this->_footer = array(
            "view_js_nav"  => $this->_js_view.'outbox_js',
            "script"       => array(
                "assets/js/plugins/datatables/jquery.dataTables.min.js",
                "assets/js/plugins/datatables/dataTables.bootstrap.min.js",
                "assets/js/plugins/datatable-responsive/datatables.responsive.min.js",
            )
        );

        //load the views.
        $this->load->view(MANAGER_HEADER , $this->_header);
        $this->load->view($this->_view_folder . 'outbox');
        $this->load->view(MANAGER_FOOTER , $this->_footer);
    }

    public function sent()
    {
        //set header attribute.
        $this->_header = array(
            "title"         => $this->_title,
            "title_page"    => $this->_title_page . '<span>> Sent Sms List </span>',
            "active_page"   => $this->_active_page .'-SENT',
            "breadcrumb"    => $this->_breadcrumb . '<li>Sent List </li>',
        );

        //set footer attribute (additional script and css).
        $this->_footer = array(
            "view_js_nav"  => $this->_js_view.'sent_js',
            "script"       => array(
                "assets/js/plugins/datatables/jquery.dataTables.min.js",
                "assets/js/plugins/datatables/dataTables.bootstrap.min.js",
                "assets/js/plugins/datatable-responsive/datatables.responsive.min.js",
            )
        );

        //load the views.
        $this->load->view(MANAGER_HEADER , $this->_header);
        $this->load->view($this->_view_folder . 'sent');
        $this->load->view(MANAGER_FOOTER , $this->_footer);
    }

    /**
     * Create an sms
     */
    public function create_personal () {
        $this->load->library('Smsgateway');
        $this->_breadcrumb .= '<li><a href="'.site_url('sms').'">Sms</a></li>';
        //load the models
        $this->load->model("Dynamic_model");

        //prepare set datas
        $params = array(
            "status" => -1,
            "row_array" => false
        );

        $data['template'] = $this->Dynamic_model->set_model(
            "tbl_sms_template", "tst","template_id"
        )->get_all_data($params)['datas'];

        //prepare header title.
        $header = array(
            "title"         => $this->_title,
            "title_page"    => $this->_title_page . '<span>> Create Sms Personal</span>',
            "title_msg"     => "Form Create",
            "active_page"   => $this->_active_page.'-CREATE-PERSONAL',
            "breadcrumb"    => $this->_breadcrumb . '<li>Create Sms Personal</li>',
            "back"          => $this->_back,
            "css" => array(
                "assets/css/select2.min.css",
            )
        );

        $footer = array(
            "view_js_nav"  => $this->_js_view.'create_js_nav_personal',
            "script"       => array(
                "assets/js/plugins/select2.full.min.js",
            )
        );

        //load the view.
        $this->load->view(MANAGER_HEADER, $header);
        $this->load->view($this->_view_folder . 'create_personal', $data);
        $this->load->view(MANAGER_FOOTER, $footer);
    }

    /**
     * Create an sms
     */
    public function create_schedule () {
        $this->_breadcrumb .= '<li><a href="'.site_url('sms').'">Sms Schedule</a></li>';
        //load the models
        $this->load->model("Dynamic_model");

        //prepare set datas
        $params = array(
            "status" => -1,
            "row_array" => false
        );

        $datas = $this->Dynamic_model->set_model(
            "tbl_sms_template", "tst","template_id"
        )->get_all_data($params)['datas'];

        $data = array(
            'datas' => $datas
        );

        //prepare header title.
        $header = array(
            "title"         => $this->_title,
            "title_page"    => $this->_title_page . '<span>> Create Sms Schedule</span>',
            "title_msg"     => "Form Create",
            "active_page"   => $this->_active_page.'-CREATE-SCHEDULE',
            "breadcrumb"    => $this->_breadcrumb . '<li>Create Sms Schedule</li>',
            "back"          => $this->_back,
            "css" => array(
                "assets/css/select2.min.css",
                "assets/js/jquery-ui-timepicker-addon.css"
            )
        );

        $footer = array(
            "view_js_nav"  => $this->_js_view.'create_js_schedule',
            "script"       => array(
                "assets/js/plugins/select2.full.min.js",
                "assets/js/jquery-ui-timepicker-addon.js"
            )
        );

        //load the view.
        $this->load->view(MANAGER_HEADER, $header);
        $this->load->view($this->_view_folder . 'create_schedule', $data);
        $this->load->view(MANAGER_FOOTER, $footer);
    }

    /**
     * Create an sms
     */
    public function replay ($no = null) {
        $this->_breadcrumb .= '<li><a href="'.site_url('sms').'">Replay Sms</a></li>';
        //load the models
        $this->load->model("Dynamic_model");

        $No62 = substr($no, 0,1 );

        if( !strcmp($No62, '0')){
            $No = substr($no, 1, strlen($no)-1);
            $No = sprintf("+62%s", $No);
        } else if(!strcmp($No62, '8')) {
            $No = sprintf("+62%s", $no);
        } else {
            $No = "+";
            $No .= $no;
        }
        //replace no
        // $no_fix = str_replace("62", "+62", $no);
        // $no_db  = str_replace("62", "0", $no);
        //prepare set datas
        $params = array(
            "select"      => "ix.*,me.Emp_Name, me.Emp_PhoneNumber",
            "left_joined" => array(
                "mst_employee me" => array("me.Emp_PhoneNumber" => "ix.SenderNumber"),
                // "sentitems si" => array("si.DestinationNumber" => "ix.SenderNumber")
            ),
            "conditions"  => array("ix.SenderNumber" => $No),
            "order_by"    => array("ix.ReceivingDateTime" => "desc"),
            "debug"       => false
        );

        //get template
        $data['template'] = $this->Dynamic_model->set_model("tbl_sms_template","tst","template_id")->get_all_data()['datas'];

        $data['inbox'] = $this->Dynamic_model->set_model("inbox","ix","ID")->get_all_data($params)['datas'];
        $data['inbox_row'] = $this->Dynamic_model->set_model("inbox","ix","ID")->get_all_data(array(
            "select"      => "ix.*,me.Emp_Name, me.Emp_PhoneNumber",
            "left_joined" => array(
                "mst_employee me" => array("me.Emp_PhoneNumber" => "ix.SenderNumber"),
                // "sentitems si" => array("si.DestinationNumber" => "ix.SenderNumber")
            ),
            "conditions"  => array("ix.SenderNumber" => $No),
            "order_by"    => array("ix.ReceivingDateTime" => "desc"),
            "row_array"   => true,
            "debug"       => false
        ))['datas'];

        $result = $this->Dynamic_model->set_model("inbox","ix","ID")->update(array(
            "IsRead" => STATUS_READ
        ),array("SenderNumber" => $No));
        // pr($data['inbox_row']);exit;
        //prepare header title.
        $header = array(
            "title"         => $this->_title,
            "title_page"    => $this->_title_page . '<span>> Replay Sms</span>',
            "title_msg"     => "Form Replay",
            "active_page"   => $this->_active_page."-CREATE-PERSONAL",
            "breadcrumb"    => $this->_breadcrumb . '<li>Replay Sms</li>',
            "back"          => $this->_back,
            "css" => array(
                "assets/css/select2.min.css",
            )
        );

        $footer = array(
            "view_js_nav"  => $this->_js_view.'replay_js',
            "script"       => array(
                "assets/js/plugins/select2.full.min.js",
                "assets/js/plugins/summernote/summernote.min.js"
            )
        );

        //load the view.
        $this->load->view(MANAGER_HEADER, $header);
        $this->load->view($this->_view_folder . 'replay', $data);
        $this->load->view(MANAGER_FOOTER, $footer);
    }

    /**
     * Create an sms broadcast to group
     */
    public function create_group () {
        $this->_breadcrumb .= '<li><a href="'.site_url('sms').'">Sms</a></li>';

        //prepare header title.
        $header = array(
            "title"         => $this->_title,
            "title_page"    => $this->_title_page . '<span>> Create Sms Broadcast</span>',
            "title_msg"     => "Form Create",
            "active_page"   => $this->_active_page ."-CREATE_GROUP",
            "breadcrumb"    => $this->_breadcrumb . '<li>Create Sms Broadcast</li>',
            "back"          => $this->_back,
        );
        $this->load->model("Dynamic_model");

        $data = $this->Dynamic_model->set_model("tbl_region","trg","region_id")->get_all_data(array(
            "row_array"  => false,
            "status"     => -1,
            "debug"      => false
        ))['datas'];

        $kategori = $this->Dynamic_model->set_model("tbl_kategori","tk","kategori_id")->get_all_data(array(
            "row_array"  => false,
            "status"     => -1,
            "debug"      => false
        ))['datas'];

        // pr($data);exit;

        //prepare set datas
        $params = array(
            "status" => -1,
            "row_array" => false
        );

        $datas = $this->Dynamic_model->set_model(
            "tbl_sms_template", "tst","template_id"
        )->get_all_data($params)['datas'];

        $data = array(
            'datas' => $data,
            'data'  => $datas,
            'kategori' => $kategori
        );

        $footer = array(
            "view_js_nav"  => $this->_js_view.'create_js_nav',
        );

        //load the view.
        $this->load->view(MANAGER_HEADER, $header);
        $this->load->view($this->_view_folder . 'create_broadcast', $data);
        $this->load->view(MANAGER_FOOTER, $footer);
    }

    /** create sms by checked data**/
    public function create_sms_checkbox()
    {
        // var_dump(1);exit();
        $this->id = $this->input->post('id_sms');

        if( strlen($this->id) > 1) {
            $this->id = explode(",",$this->id);
            $this->id = "',','".implode("','", $this->id)."'";
        } else {
            $this->id;
        }

        $this->_breadcrumb .= '<li><a href="'.site_url('sms').'">SMS</a></li>';

        $this->load->model("Dynamic_model");

        //prepare set datas
        $param = array(
            "status" => -1,
            "row_array" => false
        );

        $template = $this->Dynamic_model->set_model(
            "tbl_sms_template", "tst","template_id"
        )->get_all_data($param)['datas'];

        $data = $this->_get_data();
        //convert to 1 dimensional
        $data = array_map('current', $data);
        //array to string
        $data = implode(",", $data);
        // pr($data);exit;
        $datas = array(
            "datas"     => $data,
            "template"  => $template
        );

        //prepare header title.
        $header = array(
            "title"         => $this->_title,
            "title_page"    => $this->_title_page . '<span>> Create SMS BY Checked</span>',
            "title_msg"     => "Form Create",
            "active_page"   => "create",
            "breadcrumb"    => $this->_breadcrumb . '<li>Create SMS BY Checked</li>',
            "back"          => $this->_back,
        );

        $footer = array(
            "view_js_nav"  => $this->_js_view.'create_js_check_nav',
        );

        //load the view.
        $this->load->view(MANAGER_HEADER, $header);
        $this->load->view($this->_view_folder . 'create_sms_checkbox', $datas);
        $this->load->view(MANAGER_FOOTER, $footer);
    }

    /**
     * Edit an
     */
    // public function edit ($sms_id = null) {
    //     $this->_breadcrumb .= '<li><a href="'.site_url('sms').'">Sms Group</a></li>';

    //     //load the model.
    //     $this->load->model('Sms_model');
    //     $data['item'] = null;

    //     //validate ID and check for data.
    //     if ( $sms_id === null || !is_numeric($sms_id) ) {
    //         show_404();
    //     }

    //     $params = array("row_array" => true,"conditions" => array("sms_id" => $sms_id));
    //     //get the data.
    //     $data['item'] = $this->Group_model->get_all_data($params)['datas'];

    //     //if no data found with that ID, throw error.
    //     if (empty($data['item'])) {
    //         show_404();
    //     }

    //     //prepare header title.
    //     $header = array(
    //         "title"         => $this->_title,
    //         "title_page"    => $this->_title_page . '<span>> Edit Sms Group</span>',
    //         "active_page"   => $this->_active_page,
    //         "breadcrumb"    => $this->_breadcrumb . '<li>Edit Sms Group</li>',
    //         "back"          => $this->_back,
    //     );

    //     $footer = array(
    //         // "script" => $this->_js_path . "create.js",
    //     );

    //     //load the view.
    //     $this->load->view(MANAGER_HEADER, $header);
    //     $this->load->view($this->_view_folder . 'create', $data);
    //     $this->load->view(MANAGER_FOOTER, $footer);
    // }

    /**
     * view an
     */
    public function view_inbox ($sms_id = null) {
        $this->_breadcrumb .= '<li><a href="'.site_url('sms').'">View SMS Inbox</a></li>';

        //load the model.
        $this->load->model('Dynamic_model');

        $params = array(
            "row_array" => true,
            "conditions" => array("in.ID" => $sms_id),
            "status"     => -1,
            "debug"      => false
        );
        //get the data.
        $data['datas'] = $this->Dynamic_model->set_model("inbox","in","ID")->get_all_data($params)['datas'];
        // pr($data['item']);exit;
        //update is read
        $update = $this->Dynamic_model->set_model("inbox","in","ID")->update(
            array(
                "IsRead" => 1),
            array(
                "ID" => $sms_id)
        );
        //prepare header title.
        $header = array(
            "title"         => $this->_title,
            "title_page"    => $this->_title_page . '<span>> View Sms Inbox</span>',
            "active_page"   => $this->_active_page,
            "breadcrumb"    => $this->_breadcrumb . '<li>View Sms Inbox</li>',
            "back"          => $this->_back."/inbox",
        );

        $footer = array();

        //load the view.
        $this->load->view(MANAGER_HEADER, $header);
        $this->load->view($this->_view_folder . 'view-inbox', $data);
        $this->load->view(MANAGER_FOOTER, $footer);
    }

    public function process_form() {
        //must ajax and must post.

        //load form validation lib.
        $this->load->library('form_validation');

        //load the model.
        $this->load->model('Dynamic_model');

        //initial.
        $message['is_error'] = true;
        $message['error_msg'] = "";
        $message['redirect_to'] = "";


        //sanitize input (id is primary key, if from edit, it has value).
        $id            = $this->input->post('id');
        $no_hp         = $this->input->post('nomor');
        $no_hps        = $this->input->post('nomors');
        $type          = $this->input->post('type');
        $template_id   = $this->input->post('template_id');
        $msg           = addslashes($this->input->post('isi'));
        $creator       = $this->session->userdata('name');

        $No = $no_hp;
        $No62 = substr($No, 0,1 );
        if( !strcmp($No62, '0')){
            $No = substr($No, 1, strlen($No)-1);
            $No = sprintf("+62%s", $No);
        } else if(!strcmp($No62, '8')) {
            $No = sprintf("+62%s", $No);
        } else {
            $No = $no_hp;
        }

        $this->form_validation->set_rules('isi',"Message","required");
        $fix_no        = ($No) ? $No : $no_hps;
        

        if( $this->form_validation->run() == FALSE) {
            $message['error_msg'] = validation_errors();
        } else {
            //validation success, prepare array to DB.
            $this->db->trans_begin();
            
            if( empty($type) ) {
                $message['is_error'] = true;
                $message['error_msg'] = "Methode send message is required";
                $this->output->set_content_type('application/json');
                echo json_encode($message);
                exit;
            }

            if( $type == 2 && $no_hp == "") {
                $message['is_error'] = true;
                $message['error_msg'] = "Phone number can not be empty !!!";
                $this->output->set_content_type('application/json');
                echo json_encode($message);
                exit;
            }

            if( $type == 1 && $no_hps == "") {
                $message['is_error'] = true;
                $message['error_msg'] = "Phone number can not be empty !!!";
                $this->output->set_content_type('application/json');
                echo json_encode($message);
                exit;
            }
            //get primary key tbl outbox
            $sql       = "SHOW TABLE STATUS LIKE 'outbox'";
            $qry       = $this->db->query($sql)->result_array();
            $res       = $qry[0]['Auto_increment'];
            //cek message 
            //jika pesan lebih kecil 153 maka insert ke tbl outbox
            if( strlen($msg) <= 153) {
                $_save_data = array(
                    'DestinationNumber'   => $fix_no,
                    'TextDecoded'         => $msg,
                    'CreatorID'           => $creator,
                    'type_id'             => $type,
                    'template_id'         => $template_id
                );
                $sent_sms = $this->Dynamic_model->set_model("outbox","ot","ID")->insert($_save_data);

                // $this->Dynamic_model->set_model("tbl_daily_log","tdl","LogId")->insert(
                //     arry(
                //         "LogTitle"  => "Kirim Sms Personal",
                //         "LogUserId" => $this->session->userdata("user_id"),
                //         "LogModule" => "Pengiriman SMS",
                //         "LogDescription" => 
                //     )
                // );
            } else {
                // pembulatan keatas berapa total SMS yang akan dikirimkan nantinya
                $total_char = ceil(strlen($msg)/153);
                // memecah pesan SMS per 153 karakter
                $pecah = str_split($msg, 153);

                for($j=1;$j<=$total_char;$j++){

                    $udh = "050003A7".sprintf("%02s", $total_char).sprintf("%02s", $j);
                    $msg = $pecah[$j-1];
                    
                    if ($j==1){
                        // pesan sms yang sudah dipecah per 153 karakter tadi
                        // pecahan pertama disimpan dalam tabel outbox
                        $querySend = "INSERT INTO outbox (DestinationNumber, UDH, TextDecoded, ID, MultiPart, CreatorID)
                                      VALUES ('".$fix_no."', '$udh', '".$msg."', '$res', 'true','$creator')";
                    }else{
                        $fix_msg = addslashes($msg);
                        // pecahan selanjutnya disimpan pada tabel outbox_multipart
                        $querySend = "INSERT INTO outbox_multipart(UDH, TextDecoded, ID, SequencePosition)
                                      VALUES ('".$udh."', '".$fix_msg."', '".$res."', '".$j."')";
                    }
                    $_save_data = $this->db->query($querySend);
                }
            }


            if ( $_save_data ) {
                //$sent_sms = $this->Dynamic_model->set_model("outbox","ot","ID")->insert($_save_data);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $message['is_error'] = true;
                    $message['error_msg'] = "Internal server error";
                } else {
                    $this->db->trans_commit();
                    $message['is_error'] = false;
                    //success.
                    $message['notif_title'] = "Good!";
                    $message['notif_message'] = "SMS IS SEND.";

                    //on insert, not redirected.
                    $message['redirect_to'] = site_url('sms/outbox');
                }
            } else {
                $message['error_msg'] = "Internal server error";
            }
        }
        //encoding and returning.
        $this->output->set_content_type('application/json');
        echo json_encode($message);
        exit;
    }

    // public function process_form_schedule() {
    //     //must ajax and must post.

    //     //load form validation lib.
    //     $this->load->library('form_validation');

    //     //load the model.
    //     $this->load->model('Dynamic_model');

    //     //initial.
    //     $message['is_error'] = true;
    //     $message['error_msg'] = "";
    //     $message['redirect_to'] = "";

    //     $this->form_validation->set_rules('isi',"Message","required");

    //     //sanitize input (id is primary key, if from edit, it has value).
    //     $id            = $this->input->post('id');
    //     $no_hp         = $this->input->post('nomor');
    //     $no_hps        = $this->input->post('nomors');
    //     $type          = $this->input->post('type');
    //     $template_id   = $this->input->post('template_id');
    //     $msg           = $this->input->post('isi');
    //     $creator       = $this->session->userdata('name');
    //     $time          = $this->input->post("date_val");

    //     $time          = str_replace("/","-",$time);
    //     $time          = date("Y-m-d H:i:s", strtotime($time));
    //     $fix_no        = ($no_hp) ? $no_hp : $no_hps;
    //     // pr($time);exit;

    //     if( $this->form_validation->run() == FALSE) {
    //         $message['error_msg'] = validation_errors();
    //     } else {
    //         //validation success, prepare array to DB.
    //         $this->db->trans_begin();
    //         $_save_data = array(
    //             'DestinationNumber'   => $fix_no,
    //             'TextDecoded'         => $msg,
    //             'CreatorID'           => $creator,
    //             'SendingDateTime'     => $time,
    //             'UpdatedInDB'         => $time,
    //             'InsertIntoDB'        => $time,
    //             'type_id'             => $type,
    //             'template_id'         => $template_id
    //         );
    //         if ( $_save_data ) {
    //             // pr($this->input->post());exit;
    //             $sent_sms = $this->Dynamic_model->set_model("outbox","ot","ID")->insert($_save_data);
    //             if ($this->db->trans_status() === FALSE) {
    //                 $this->db->trans_rollback();
    //                 $message['is_error'] = true;
    //                 $message['error_msg'] = "Internal server error";
    //             } else {
    //                 $this->db->trans_commit();
    //                 $message['is_error'] = false;
    //                 //success.
    //                 $message['notif_title'] = "Good!";
    //                 $message['notif_message'] = "SMS IS SEND.";

    //                 //on insert, not redirected.
    //                 $message['redirect_to'] = site_url('sms/outbox');
    //             }
    //         } else {
    //             $message['error_msg'] = "Internal server error";
    //         }
    //     }
    //     //encoding and returning.
    //     $this->output->set_content_type('application/json');
    //     echo json_encode($message);
    //     exit;
    // }
    /*
    * function proses send sms checkbox
    * json data
    */
    public function process_form_checkbox() {
        //load form validation lib.
        $this->load->library('form_validation');

        //load the model.
        $this->load->model('Dynamic_model');

        $this->form_validation->set_rules("message","Message","required");
        //initial.
        $message['is_error'] = true;
        $message['error_msg'] = "";
        $message['redirect_to'] = "";

        $id            = $this->input->post('id');
        $type          = $this->input->post('type');
        $no_sms        = $this->input->post('no_sms');
        $template_id   = $this->input->post('template_id');
        $msg           = $this->input->post('message');
        $creator       = $this->session->userdata('name');
        $id_sms = implode(",", $no_sms);

        $sql       = "SHOW TABLE STATUS LIKE 'outbox'";
        $qry       = $this->db->query($sql)->result_array();
        $res       = $qry[0]['Auto_increment'];
        // pr($id_sms);exit;
        if( $this->form_validation->run() == FALSE ) {
            $message['error_msg'] = validation_errors();
        } else {
            $this->db->trans_begin();
            $data = $this->Dynamic_model->set_model("mst_employee","me","Emp_Id")->get_all_data(array(
                "select" => "Emp_PhoneNumber",
                "conditions" => array("me.Emp_Id IN (".$id_sms.")" => NULL),
                "debug"     => false
            ))['datas'];
            // pr($data);exit;
            foreach( $data as $key => $val) {

                if( strlen($msg) <= 153) {
                    $_save_data = array(
                        'DestinationNumber'   => $val['Emp_PhoneNumber'],
                        'TextDecoded'         => $msg,
                        'CreatorID'           => $creator,
                        'type_id'             => $type,
                        'template_id'         => $template_id
                    );

                    $sent_sms = $this->Dynamic_model->set_model("outbox","ot","ID")->insert($_save_data);
                } else {
                    // pembulatan keatas berapa total SMS yang akan dikirimkan nantinya
                    $total_char = ceil(strlen($msg)/153);
                    // memecah pesan SMS per 153 karakter
                    $pecah = str_split($msg, 153);

                    for($j=1;$j<=$total_char;$j++){

                        $udh = "050003A7".sprintf("%02s", $total_char).sprintf("%02s", $j);
                        $msg = $pecah[$j-1];
                        
                        if ($j==1){
                            // pesan sms yang sudah dipecah per 153 karakter tadi
                            // pecahan pertama disimpan dalam tabel outbox
                            $querySend = "INSERT INTO outbox (DestinationNumber, UDH, TextDecoded, ID, MultiPart, CreatorID)
                                          VALUES ('".$val['UserMobilePhone']."', '$udh', '".$msg."', '$res', 'true','$creator')";
                        }else{
                            $fix_msg = addslashes($msg);
                            // pecahan selanjutnya disimpan pada tabel outbox_multipart
                            $querySend = "INSERT INTO outbox_multipart(UDH, TextDecoded, ID, SequencePosition)
                                          VALUES ('".$udh."', '".$msg."', '".$res."', '".$j."')";
                        }
                        $sent_sms = $this->db->query($querySend);
                    }
                }
                // $check_no = 
                // $_save_data = array(
                //     "DestinationNumber" => $val['UserMobilePhone'],
                //     "TextDecoded"  => $msg,
                //     "CreatorID"    => $creator
                // );
                // $sent_sms = $this->Dynamic_model->set_model("outbox","ot","ID")->insert($_save_data);
            }
            //check post is true
            if ($sent_sms) {

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $message['is_error'] = true;
                    $message['error_msg'] = "Internal server error";
                } else {
                    $this->db->trans_commit();
                    $message['is_error'] = false;
                    //success.
                    $message['notif_title'] = "Good!";
                    $message['notif_message'] = "SMS IS SEND.";

                    //on insert, not redirected.
                    $message['redirect_to'] = site_url('sms/outbox');
                }
            } else {
                $message['error_msg'] = "Internal Server Error!!!";
            }
        }
        //encoding and returning.
        $this->output->set_content_type('application/json');
        echo json_encode($message);
        exit;
    }

    /*
    * function send replay sms
    */
    public function process_form_replay(){
        if (!$this->input->is_ajax_request() || $this->input->method(true) != "POST") {
            exit('No direct script access allowed');
        }
        //must ajax and must post.
        //load form validation lib.
        $this->load->library('form_validation');

        //load the model.
        $this->load->model('Dynamic_model');

        $this->form_validation->set_rules('content',"Message","required");

        //initial.
        $message['is_error'] = true;
        $message['error_msg'] = "";
        $message['redirect_to'] = "";

        //sanitize input (id is primary key, if from edit, it has value).
        $id            = $this->input->post('id');
        $no_hp         = $this->input->post('nomor');
        $template_id   = $this->input->post('template_id');
        $msg           = $this->input->post('content');
        $creator       = $this->session->userdata("name");

        if( $this->form_validation->run() == FALSE) {
            $message['error_msg'] = validation_errors();
        } else {
            $this->db->trans_begin();
            //validation success, prepare array to DB.
            $_save_data = array(
                'DestinationNumber'   => $no_hp,
                'TextDecoded'         => $msg,
                'CreatorID'           => $creator
            );
            //check post is true
            if ($_save_data) {
                //send
                $sent_sms = $this->Dynamic_model->set_model("outbox","ot","ID")->insert($_save_data);
                //update is read
                $update = $this->Dynamic_model->set_model("inbox","in","ID")->update(
                    array(
                        "IsRead" => 1),
                    array(
                        "ID" => $id)
                );
                
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $message['is_error'] = true;
                    $message['error_msg'] = "Internal server error";
                } else {
                    $this->db->trans_commit();
                    $message['is_error'] = false;
                    //success.
                    $message['notif_title'] = "Good!";
                    $message['notif_message'] = "SMS IS SEND.";

                    //on insert, not redirected.
                    $message['redirect_to'] = "";
                }
            } else {
                $message['error_msg'] = "Internal Server Error!!!";
            }
        }
        //encoding and returning.
        $this->output->set_content_type('application/json');
        echo json_encode($message);
        exit;
    }

    /*
    * function process send broadcast to group
    */
    public function process_forms() {

        //load form validation lib.
        $this->load->library('form_validation');

        //load the model.
        $this->load->model('Dynamic_model');
        //server validation
        $this->form_validation->set_rules("message","Message","required");

        //initial.
        $message['is_error'] = true;
        $message['error_msg'] = "";
        $message['redirect_to'] = "";

        $no_hp          = $this->input->post('no');
        $template_id    = $this->input->post('template_id');
        $msg            = $this->input->post('message');
        $group_id       = $this->input->post('group_id');
        $kategori_id    = $this->input->post('kategori_id');
        $create         = $this->session->userdata('user_id');

        if( $this->form_validation->run() == FALSE ) {
            $message['error_msg'] = validation_errors();
        } else {
            //validation success, prepare array to DB.
            $this->db->trans_begin();

            $data = $this->Dynamic_model->set_model("mst_employee","me","Emp_Id")->get_all_data(array(
                "select" => "me.Emp_PhoneNumber ",
                "joined" => array("tbl_kategori tk" => array("tk.kategori_id" => "me.Emp_KategoriId"),
                    "tbl_region tr" => array("tr.region_id" => "me.Emp_AreaId")
                ),
                "conditions" => array("tr.region_id" => $group_id, "tk.kategori_id" => $kategori_id),
                "debug" => false
            ))['datas'];
            // pr($data);exit;
            // pr($grup);exit();
            // $_save_data = [];
            foreach ($data as $key => $val)
            {
                $_save_data = array(
                    "DestinationNumber" => $val['Emp_PhoneNumber'],
                    "TextDecoded"  => $msg,
                    "CreatorID"    => $create,
                    "type_id"      => 3,
                    "template_id"  => $template_id,
                    "OutGroupId"   => $group_id
                );
                // pr($_save_data);exit;
                $result = $this->Dynamic_model->set_model("outbox","ot","ID")->insert($_save_data);
            }
                
                
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $message['is_error'] = true;
                $message['error_msg'] = "Internal server error";
            } else {
                $this->db->trans_commit();
                $message['is_error'] = false;
                //success.
                $message['notif_title'] = "Good!";
                $message['notif_message'] = "SMS IS SEND.";

                //on insert, not redirected.
                $message['redirect_to'] = site_url('sms/outbox');
            }
            // $message['error_msg'] = "Internal server error";
        }
        //encoding and returning.
        $this->output->set_content_type('application/json');
        echo json_encode($message);
        exit;
    }

    /**
     * Function to get list_all_data
     */
    public function list_all_data_inbox() {
        //must ajax and must get.
        if (!$this->input->is_ajax_request() || $this->input->method(true) != "GET") {
            exit('No direct script access allowed');
        }

        //load model
        $this->load->model('Sms_model');

        $sort_col = sanitize_str_input($this->input->get("order")['0']['column'], "numeric");
        $sort_dir = sanitize_str_input($this->input->get("order")['0']['dir']);
        $limit    = sanitize_str_input($this->input->get("length"), "numeric");
        $start    = sanitize_str_input($this->input->get("start"), "numeric");
        $search   = sanitize_str_input($this->input->get("search")['value']);
        $filter   = $this->input->get("filter");

        $select   = array("
            (CASE WHEN me.Emp_PhoneNumber = ix.SenderNumber THEN me.Emp_Name ELSE ix.SenderNumber END) as SenderNumbers","SenderNumber","ID","ReceivingDateTime","TextDecoded","IF(IsRead = 1, 'READ', 'UNREAD') as statusSms");

        $left_joined = array("mst_employee me" => array("me.Emp_PhoneNumber" => "ix.SenderNumber"));

        $column_sort = $select[$sort_col];

        //initialize.
        $data_filters = array();
        $conditions = array();
        $status = STATUS_ACTIVE;

        if (count ($filter) > 0) {
            foreach ($filter as $key => $value) {
                $value = ($value);
                switch ($key) {
                    case 'id':
                        if ($value != "") {
                            $data_filters['lower(inbox_id)'] = $value;
                        }
                        break;
                    case 'from':
                        if ($value != "") {
                            $data_filters['lower(inbox_sendnumber)'] = $value;
                        }
                        break;
                    default:
                        break;
                }
            }
        }

        //get data
        $datas = $this->Sms_model->set_model("inbox","ix","ID")->get_all_data(array(
            'select'          => $select,
            'left_joined'     => $left_joined,
            'order_by'        => array($column_sort => $sort_dir),
            'limit'           => $limit,
            'start'           => $start,
            'conditions'      => $conditions,
            'filter'          => $data_filters,
            'status'          => -1,
            'group_by'        => array("SenderNumber"),
            'order_by'        => array("ReceivingDateTime" => "desc"),  
            'count_all_first' => true,
            // 'debug'           => true,
        ));

        //get total rows
        $total_rows = $datas['total'];

        $output = array(
            "data" => $datas['datas'],
            "draw" => intval($this->input->get("draw")),
            "recordsTotal" => $total_rows,
            "recordsFiltered" => $total_rows,
        );

        //encoding and returning.
        $this->output->set_content_type('application/json');
        echo json_encode($output);
        exit;
    }

    /**
     * Function to get list_all_data admin
     */
    public function list_all_data_sent() {
        //must ajax and must get.
        if (!$this->input->is_ajax_request() || $this->input->method(true) != "GET") {
            exit('No direct script access allowed');
        }

        //load model
        $this->load->model('Dynamic_model');

        $sort_col = sanitize_str_input($this->input->get("order")['0']['column'], "numeric");
        $sort_dir = sanitize_str_input($this->input->get("order")['0']['dir']);
        $limit    = sanitize_str_input($this->input->get("length"), "numeric");
        $start    = sanitize_str_input($this->input->get("start"), "numeric");
        $search   = sanitize_str_input($this->input->get("search")['value']);
        $filter   = $this->input->get("filter");

        $select   = array("ID","DestinationNumber","TextDecoded","Status");

        $column_sort = $select[$sort_col];

        //initialize.
        $data_filters = array();
        $conditions = array();
        $status = STATUS_ACTIVE;

        if (count ($filter) > 0) {
            foreach ($filter as $key => $value) {
                $value = ($value);
                switch ($key) {
                    case 'id':
                        if ($value != "") {
                            $data_filters['lower(inbox_id)'] = $value;
                        }
                        break;
                    case 'from':
                        if ($value != "") {
                            $data_filters['lower(inbox_sendnumber)'] = $value;
                        }
                        break;
                    default:
                        break;
                }
            }
        }

        //get data
        $datas = $this->Dynamic_model->set_model("sentitems","ts","ID")->get_all_data(array(
            'select' => $select,
            'order_by' => array($column_sort => $sort_dir),
            'limit' => $limit,
            'start' => $start,
            'conditions' => $conditions,
            'filter' => $data_filters,
            'status' => -1,
            // 'group_by' => array("ts.DestinationNumber"),
            'debug' => false,
            "count_all_first" => true
        ));

        //get total rows
        $total_rows = $datas['total'];

        $output = array(
            "data" => $datas['datas'],
            "draw" => intval($this->input->get("draw")),
            "recordsTotal" => $total_rows,
            "recordsFiltered" => $total_rows,
        );

        //encoding and returning.
        $this->output->set_content_type('application/json');
        echo json_encode($output);
        exit;
    }

    /**
     * Function to get list_all_data admin
     */
    public function list_all_data_outbox() {
        //must ajax and must get.
        if (!$this->input->is_ajax_request() || $this->input->method(true) != "GET") {
            exit('No direct script access allowed');
        }

        //load model
        $this->load->model('Dynamic_model');

        $sort_col = sanitize_str_input($this->input->get("order")['0']['column'], "numeric");
        $sort_dir = sanitize_str_input($this->input->get("order")['0']['dir']);
        $limit    = sanitize_str_input($this->input->get("length"), "numeric");
        $start    = sanitize_str_input($this->input->get("start"), "numeric");
        $search   = sanitize_str_input($this->input->get("search")['value']);
        $filter   = $this->input->get("filter");

        $select   = array("ID","DestinationNumber","TextDecoded","Status");

        $column_sort = $select[$sort_col];

        //initialize.
        $data_filters = array();
        $conditions = array();
        $status = STATUS_ACTIVE;

        if (count ($filter) > 0) {
            foreach ($filter as $key => $value) {
                $value = ($value);
                switch ($key) {
                    case 'mobile':
                        if ($value != "") {
                            $data_filters['lower(DestinationNumber)'] = $value;
                        }
                        break;
                    default:
                        break;
                }
            }
        }

        //get data
        $datas = $this->Dynamic_model->set_model("outbox","ot","ID")->get_all_data(array(
            'select' => $select,
            'order_by' => array($column_sort => $sort_dir),
            'limit' => $limit,
            'start' => $start,
            'conditions' => $conditions,
            'filter' => $data_filters,
            'status' => -1,
            'debug' => false,
            "count_all_first" => true
        ));

        //get total rows
        $total_rows = $datas['total'];

        $output = array(
            "data" => $datas['datas'],
            "draw" => intval($this->input->get("draw")),
            "recordsTotal" => $total_rows,
            "recordsFiltered" => $total_rows,
        );

        //encoding and returning.
        $this->output->set_content_type('application/json');
        echo json_encode($output);
        exit;
    }

    /**
    * function for get template
    * @param json object
    **/
    public function get_template()
    {
        if (!$this->input->is_ajax_request() || $this->input->method(true) != "POST") {
            exit('No direct script access allowed');
        }
        //initials
        $message['is_error']  = true;
        $message['error_msg'] = "";

        // load models
        $this->load->model("Dynamic_model");

        $id = $this->input->post('id');

        //prepare get data
        $params = array(
            "select"        => "*",
            "conditions"    => array("template_id" => $id),
            "row_array"     => false,
            "status"        => -1,
            "debug"         => false
        );

        $result = $this->Dynamic_model->set_model("tbl_sms_template","tst","template_id")->get_all_data($params)['datas'];

        if( !$result )
        {
            $message['is_error']  = true;
            $message['error_msg'] = "Invalid ID";
        } else {

            $message['is_error']  = false;
            $message['error_msg'] = "";
            $message['datas']      = $result;
        }

        //encoding and returning.
        $this->output->set_content_type('application/json');
        echo json_encode($message);
        exit;
    }

    /**
    * function for get template
    * @param json object
    **/
    public function get_no_broadcast()
    {
        if (!$this->input->is_ajax_request() || $this->input->method(true) != "POST") {
            exit('No direct script access allowed');
        }
        //initials
        $message['is_error']  = true;
        $message['error_msg'] = "";

        // load models
        $this->load->model("Sms_model");

        $id = $this->input->post('id');
        $result = $this->Sms_model->get_no_broadcast($id);

        if( !$result && empty($id))
        {
            $message['is_error']  = true;
            $message['error_msg'] = "Invalid ID";
        } else {
            //convert to array 1 dimensional
            $one_dimensi = iterator_to_array(
                new RecursiveIteratorIterator(
                    new RecursiveArrayIterator($result)
                ), 0
            );
            $message['is_error']  = false;
            $message['error_msg'] = "success get data";
            $message['datas']     = $one_dimensi;
            // print_r($one_dimensi);
        }
        //encoding and returning.
        $this->output->set_content_type('application/json');
        echo json_encode($message);
        exit;
    }

    public function list_select_no()
    {
        //must ajax and must get.
        if (!$this->input->is_ajax_request() || $this->input->method(true) != "GET") {
            exit('No direct script access allowed');
        }
        $this->load->model("Dynamic_model");
        //initials filter page
        $select_q       = $this->input->get('q');
        $select_page    = ($this->input->get('page')) ? $this->input->get('page') : 1;
        //set value limit = 10;
        $limit = 10;
        $start = ($limit * ($select_page - 1));

        //initials
        $filters = array();

        //statement
        if($select_q != "") {
            $filters['Emp_Name'] = $select_q;
        }

        $conditions = array();

        //prepare get data
        $params = $this->Dynamic_model->set_model("mst_employee","me","Emp_Id")->get_all_data(array(
            "select"            => "Emp_PhoneNumber, Emp_Name",
            "count_all_first"   => true,
            "filter_or"         => $filters,
            "conditions"        => $conditions,
            "limit"             => $limit,
            "start"             => $start,
            "status"            => -1
        ));

        //prepare returns.
        $message["page"]        = $select_page;
        $message["total_data"]  = $params['total'];
        $message["paging_size"] = $limit;
        $message["datas"]       = $params['datas'];

        $this->output->set_content_type('application/json');
        echo json_encode($message);
        exit;
    }

    public function delete_inbox()
    {
        //must ajax and must post.
        if (!$this->input->is_ajax_request() || $this->input->method(true) != "POST") {
            exit('No direct script access allowed');
        }
        $message['is_error'] = true;
        $message['error_msg'] = "";
        $this->load->model('Dynamic_model');

        $id = $this->input->post('id');

        if( empty( $id )) {
            $message['error_msg'] = "Invalid ID";
        } else {
            $condition = array("ID" => $id);
            $result = $this->Dynamic_model->set_model("inbox","inb","ID")->delete( $condition );

            if(!$result ) {
                $message['is_error']    = true;
                $message['error_msg']   = "Internal server error !!!";
            } else {
                $message['is_error']    = false;
                $message['notif_title'] = "Success!!";
                $message['notif_message'] = "Inbox has been deleted.";
                $message['redirect_to'] = '';
            }
        }
        $this->output->set_content_type('application/json');
        echo json_encode($message);
        exit;
    }

    public function delete_outbox()
    {
        //must ajax and must post.
        if (!$this->input->is_ajax_request() || $this->input->method(true) != "POST") {
            exit('No direct script access allowed');
        }
        $message['is_error'] = true;
        $message['error_msg'] = "";
        $this->load->model('Dynamic_model');

        $id = $this->input->post('id');

        if( empty( $id )) {
            $message['error_msg'] = "Invalid ID";
        } else {
            $condition = array("ID" => $id);
            $result = $this->Dynamic_model->set_model("outbox","inb","ID")->delete( $condition );

            if(!$result ) {
                $message['is_error']    = true;
                $message['error_msg']   = "Internal server error !!!";
            } else {
                $message['is_error']    = false;
                $message['notif_title'] = "Success!!";
                $message['notif_message'] = "Inbox has been deleted.";
                $message['redirect_to'] = '';
            }
        }
        $this->output->set_content_type('application/json');
        echo json_encode($message);
        exit;
    }

    public function delete_sent()
    {
        //must ajax and must post.
        if (!$this->input->is_ajax_request() || $this->input->method(true) != "POST") {
            exit('No direct script access allowed');
        }
        $message['is_error'] = true;
        $message['error_msg'] = "";
        $this->load->model('Dynamic_model');

        $id = $this->input->post('id');

        if( empty( $id )) {
            $message['error_msg'] = "Invalid ID";
        } else {
            $condition = array("ID" => $id);
            $result = $this->Dynamic_model->set_model("sentitems","si","ID")->delete( $condition );

            if(!$result ) {
                $message['is_error']    = true;
                $message['error_msg']   = "Internal server error !!!";
            } else {
                $message['is_error']    = false;
                $message['notif_title'] = "Success!!";
                $message['notif_message'] = "Sent has been deleted.";
                $message['redirect_to'] = '';
            }
        }
        $this->output->set_content_type('application/json');
        echo json_encode($message);
        exit;
    }

    //get data by checked
    public function _get_data()
    {
        $this->load->model("Dynamic_model");
        //$this->id = $this->input->post('id_sms');

        $params = array(
            "select"        => "Emp_Id",
            "conditions"    => array("me.Emp_Id in(".$this->id.") " => null),
            "status"        => -1,
            "debug"         => false
        );

        $data = $this->Dynamic_model->set_model("mst_employee","me","Emp_Id")->get_all_data($params)['datas'];
        // pr($data);exit;
        return $data;
    }
 
    //load auto chat
    public function load_chat ($no)
    {

        $this->load->model('Sms_model');

        $No62 = substr($no, 0,1 );

        if( !strcmp($No62, '0')){
            $No = substr($no, 1, strlen($no)-1);
            $No = sprintf("+62%s", $No);
        } else if(!strcmp($No62, '8')) {
            $No = sprintf("+62%s", $no);
        } else {
            $No = "+";
            $No .= $no;
        }

        $data = $this->Sms_model->get_conv_chat($No);

        foreach ($data as $key => $val) {

            echo "<li class='message'>";
            echo "<div class='username' style='color:red;'>";
            echo $val['Folder'];
            echo "</div>";
            echo "<div class='message-text'>";
            echo "<time>";
            echo $val['Time'];
            echo "</time>";
            echo '<div class="panel panel-info">';
            echo '<div class="panel-body">';
            echo $val['Pesan'];
            echo '</div>';
            echo '</div>';
            echo "</div>";
            echo "</div>";
            echo "</li>";

            // $result = $this->Dynamic_model->set_model("tbl_chat","tc","ChatId")->update(array(
            //     "ChatIsRead" => STATUS_READ,
            // ),array( "ChatId" => $val['ChatId']));
        } 
    }
}