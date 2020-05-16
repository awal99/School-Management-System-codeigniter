<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*	
 *	@author : Zinnia Tech
 *	date	: 16th JUne, 2018
 */

class Student extends CI_Controller
{
    
    
    function __construct()
    {
        parent::__construct();
		$this->load->database();
        $this->load->library('session');


        $this->load->library('user_agent');
		
       /*cache control*/
       if(!$this->agent->is_mobile()){
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");       
       }
    }
    
    /***default functin, redirects to login page if no admin logged in yet***/
    public function index()
    {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('student_login') == 1)
            redirect(base_url() . 'index.php?student/dashboard', 'refresh');
    }
    
    /***Student DASHBOARD***/
    function dashboard()
    {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('student_dashboard');
        $this->db->where('id',$this->session->userdata('school'));
        $page_data['settings']   = $this->db->get('s_settings');
        $this->load->view('backend/index', $page_data);
    }
    
    
    /****MANAGE TEACHERS*****/
    function teacher_list($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        if ($param1 == 'personal_profile') {
            $page_data['personal_profile']   = true;
            $page_data['current_teacher_id'] = $param2;
        }
        $page_data['teachers']   = $this->db->get_where('teacher',array('school_id'=>$this->session->userdata('school')))->result_array();
        $page_data['page_name']  = 'teacher';
        $page_data['page_title'] = get_phrase('manage_teacher');
        $this->db->where('id',$this->session->userdata('school'));
        $page_data['settings']   = $this->db->get('s_settings');
        $this->load->view('backend/index', $page_data);
    }
    
    
    /***********************************************************************************************************/
    
    
    
    /****MANAGE SUBJECTS*****/
    function subject($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        
        $student_profile         = $this->db->get_where('student', array(
            'student_id' => $this->session->userdata('student_id')
        ))->row();
        $student_class_id        = $student_profile->class_id;
        $page_data['subjects']   = $this->db->get_where('subject', array(
            'school_id' => $this->session->userdata('school'),
            'class_id' => $student_class_id
        ))->result_array();
        $page_data['page_name']  = 'subject';
        $page_data['page_title'] = get_phrase('manage_subject');
        $this->db->where('id',$this->session->userdata('school'));
        $page_data['settings']   = $this->db->get('s_settings');
        $this->load->view('backend/index', $page_data);
    }
    
    
    
    /****MANAGE EXAM MARKS*****/
    function marks($exam_id = '', $class_id = '', $subject_id = '')
    {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        
        $student_profile       = $this->db->get_where('enroll', array(
            'student_id' => $this->session->userdata('student_id'),
            'year' =>   $this->session->userdata('running_year')
        ))->row();
        $page_data['class_id'] = $student_profile->class_id;
         $page_data['student_id'] = $this->session->userdata('student_id') ;
         //$this->db->get_where('student', array( 'student_id' => $this->session->userdata('student_id') 
			//				))->row()->student_id;
        
        if ($this->input->post('operation') == 'selection') {
            $page_data['exam_id']    = $this->input->post('exam_id');
            //$page_data['class_id']	=	$this->input->post('class_id');
            $page_data['subject_id'] = $this->input->post('subject_id');
            
            if ($page_data['exam_id'] > 0 && $page_data['class_id'] > 0 && $page_data['subject_id'] > 0) {
                redirect(base_url() . 'index.php?student/marks/' . $page_data['exam_id'] . '/' . $page_data['class_id'] . '/' . $page_data['subject_id'], 'refresh');
            } else {
                $this->session->set_flashdata('mark_message', 'Choose exam, class and subject');
                redirect(base_url() . 'index.php?student/marks/', 'refresh');
            }
        }
        $page_data['exam_id']    = $exam_id;
        //$page_data['class_id']	=	$class_id;
        $page_data['subject_id'] = $subject_id;
        
        $page_data['page_info'] = 'Exam marks';
        
        $page_data['page_name']  = 'marks';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->db->where('id',$this->session->userdata('school'));
        $page_data['settings']   = $this->db->get('s_settings');
        $this->load->view('backend/index', $page_data);
    }
    
    function marks_manage()
    {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');

        $student_profile       = $this->db->get_where('enroll', array(
            'student_id' => $this->session->userdata('student_id'),
            'year' =>   $this->session->userdata('running_year')
        ))->row();
        $page_data['student_id'] = $this->session->userdata('student_id') ;
        $page_data['class_id'] = $student_profile->class_id;
        $page_data['page_name']  =   'marks_manage';
        $page_data['running_year'] = $this->session->userdata('running_year');
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->db->where('id',$this->session->userdata('school'));
        $page_data['settings']   = $this->db->get('s_settings');
        $this->load->view('backend/index', $page_data);
    }

    function student_marksheet_print_view($student_id , $exam_id) {
        $student_id = urldecode($student_id);
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        $class_id     = $this->db->get_where('enroll' , array(
            'student_id' => $student_id , 'year' => $this->session->userdata('running_year')
        ))->row()->class_id;
        $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;

        $page_data['student_id'] =   $student_id;
        $page_data['class_id']   =   $class_id;
        $page_data['exam_id']    =   $exam_id;
        $this->load->view('backend/student/student_marksheet_print_view', $page_data);
    }


    function marks_manage_view($exam_id = '' , $class_id = '' , $section_id = '' )
    {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['exam_id']    =   $exam_id;
        $page_data['class_id']   =   $class_id;
       // $page_data['subject_id'] =   $subject_id;
        $page_data['section_id'] =   $section_id;
        $page_data['running_year'] = $this->session->userdata('running_year');
        $page_data['page_name']  =   'marks_manage_view';
        $page_data['page_title'] = get_phrase('manage_exam_marks');
        $this->db->where('id',$this->session->userdata('school'));
        $page_data['settings']   = $this->db->get('s_settings');
        $this->load->view('backend/index', $page_data);
    }


    function marks_selector()
    {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');

        $data['exam_id']    = $this->input->post('exam_id');
        $data['class_id']   = $this->input->post('class_id');
       
        if($this->input->post('section_id') != ''){
            $data['section_id'] = $this->input->post('section_id');
        }else{
            $data['section_id'] = 0;
        }
       
        $data['subject_id'] = $this->input->post('subject_id');
        $data['year']       = $this->session->userdata('running_year');
        $data['school_id']  =  $this->session->userdata('school');
        // $query = $this->db->get_where('mark' , array(
        //     'school_id'=>$data['school_id'],
        //             'exam_id' => $data['exam_id'],
        //                 'class_id' => $data['class_id'],
        //                     'section_id' => $data['section_id'],
        //                         'subject_id' => $data['subject_id'],
        //                             'year' => $data['year']
        //         ));
        //if($query->num_rows() < 1) {
            // $students = $this->db->get_where('enroll' , array(
            //     'class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'year' => $data['year']
            // ))->result_array();
            // foreach($students as $row) {
            //     $data['student_id'] = $row['student_id'];
            //     $this->db->insert('mark' , $data);
            // }
        //}
        redirect(base_url() . 'index.php?student/marks_manage_view/' . $data['exam_id'] . '/' . $data['class_id'] . '/' . $data['section_id']  , 'refresh');
        
    }

    
    /**********MANAGING CLASS ROUTINE******************/
    function class_routine($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        
        $student_profile         = $this->db->get_where('enroll', array(
            'student_id' => $this->session->userdata('student_id'),
            'year' => $this->session->userdata('running_year')
        ))->row();
        $page_data['class_id']   = $student_profile->class_id;
        $page_data['section_id'] = $student_profile->section_id;
        $page_data['page_name']  = 'class_routine';
        $page_data['page_title'] = get_phrase('manage_class_routine');
        $this->db->where('id',$this->session->userdata('school'));
        $page_data['settings']   = $this->db->get('s_settings');
        $this->load->view('backend/index', $page_data);
    }
    
    function class_routine_print_view($class_id , $section_id)
    {
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        $page_data['class_id']   =   $class_id;
        $page_data['section_id'] =   $section_id;
        $this->db->where('id',$this->session->userdata('school'));
        $page_data['settings']   = $this->db->get('s_settings');
        $this->load->view('backend/student/class_routine_print_view' , $page_data);
    }
    

    /******MANAGE BILLING / INVOICES WITH STATUS*****/
    function invoice($param1 = '', $param2 = '', $param3 = '')
    {
        //if($this->session->userdata('student_login')!=1)redirect(base_url() , 'refresh');
        if ($param1 == 'make_payment') {
            $invoice_id      = $this->input->post('invoice_id');
            $system_settings = $this->db->get_where('settings', array(
                'type' => 'paypal_email'
            ))->row();
            $invoice_details = $this->db->get_where('invoice', array(
                'invoice_id' => $invoice_id
            ))->row();
            
            /****TRANSFERRING USER TO PAYPAL TERMINAL****/
            $this->paypal->add_field('rm', 2);
            $this->paypal->add_field('no_note', 0);
            $this->paypal->add_field('item_name', $invoice_details->title);
            $this->paypal->add_field('amount', $invoice_details->amount);
            $this->paypal->add_field('custom', $invoice_details->invoice_id);
            $this->paypal->add_field('business', $system_settings->description);
            $this->paypal->add_field('notify_url', base_url() . 'index.php?student/invoice/paypal_ipn');
            $this->paypal->add_field('cancel_return', base_url() . 'index.php?student/invoice/paypal_cancel');
            $this->paypal->add_field('return', base_url() . 'index.php?student/invoice/paypal_success');
            
            $this->paypal->submit_paypal_post();
            // submit the fields to paypal
        }
        if ($param1 == 'paypal_ipn') {
            if ($this->paypal->validate_ipn() == true) {
                $ipn_response = '';
                foreach ($_POST as $key => $value) {
                    $value = urlencode(stripslashes($value));
                    $ipn_response .= "\n$key=$value";
                }
                $data['payment_details']   = $ipn_response;
                $data['payment_timestamp'] = strtotime(date("m/d/Y"));
                $data['payment_method']    = 'paypal';
                $data['status']            = 'paid';
                $invoice_id                = $_POST['custom'];
                $this->db->where('invoice_id', $invoice_id);
                $this->db->update('invoice', $data);

                $data2['method']       =   'paypal';
                $data2['invoice_id']   =   $_POST['custom'];
                $data2['timestamp']    =   strtotime(date("m/d/Y"));
                $data2['payment_type'] =   'income';
                $data2['title']        =   $this->db->get_where('invoice' , array('invoice_id' => $data2['invoice_id']))->row()->title;
                $data2['description']  =   $this->db->get_where('invoice' , array('invoice_id' => $data2['invoice_id']))->row()->description;
                $data2['student_id']   =   $this->db->get_where('invoice' , array('invoice_id' => $data2['invoice_id']))->row()->student_id;
                $data2['amount']       =   $this->db->get_where('invoice' , array('invoice_id' => $data2['invoice_id']))->row()->amount;
                $this->db->insert('payment' , $data2);
            }
        }
        if ($param1 == 'paypal_cancel') {
            $this->session->set_flashdata('flash_message', get_phrase('payment_cancelled'));
            redirect(base_url() . 'index.php?student/invoice/', 'refresh');
        }
        if ($param1 == 'paypal_success') {
            $this->session->set_flashdata('flash_message', get_phrase('payment_successfull'));
            redirect(base_url() . 'index.php?student/invoice/', 'refresh');
        }
        $student_profile         = $this->db->get_where('student', array(
            'student_id'   => $this->session->userdata('student_id')
        ))->row();
        $student_id              = $student_profile->student_id;
        $page_data['invoices']   = $this->db->get_where('invoice', array(
            'student_id' => $student_id
        ))->result_array();
        $page_data['page_name']  = 'invoice';
        $page_data['page_title'] = get_phrase('manage_invoice/payment');
        $this->db->where('id',$this->session->userdata('school'));
        $page_data['settings']   = $this->db->get('s_settings');
        $this->load->view('backend/index', $page_data);
    }
    
    /**********MANAGE LIBRARY / BOOKS********************/
    function book($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        
        $page_data['books']      = $this->db->get_where('book',array('school_id'=>$this->session->userdata('school')))->result_array();
        $page_data['page_name']  = 'book';
        $page_data['page_title'] = get_phrase('manage_library_books');
        $this->db->where('id',$this->session->userdata('school'));
        $page_data['settings']   = $this->db->get('s_settings');
        $this->load->view('backend/index', $page_data);
        
    }
    /**********MANAGE TRANSPORT / VEHICLES / ROUTES********************/
    function transport($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        
        $page_data['transports'] = $this->db->get_where('transport',array('school_id'=>$this->session->userdata('school')))->result_array();
        $page_data['page_name']  = 'transport';
        $page_data['page_title'] = get_phrase('manage_transport');
        $this->db->where('id',$this->session->userdata('school'));
        $page_data['settings']   = $this->db->get('s_settings');
        $this->load->view('backend/index', $page_data);
        
    }
    /**********MANAGE DORMITORY / HOSTELS / ROOMS ********************/
    function dormitory($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        
        $page_data['dormitories'] = $this->db->get_where('dormitory',array('school_id'=>$this->session->userdata('school')))->result_array();
        $page_data['page_name']   = 'dormitory';
        $page_data['page_title']  = get_phrase('manage_dormitory');
        $this->db->where('id',$this->session->userdata('school'));
        $page_data['settings']   = $this->db->get('s_settings');
        $this->load->view('backend/index', $page_data);
        
    }
    
    /**********WATCH NOTICEBOARD AND EVENT ********************/
    function noticeboard($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        
        $page_data['notices']    = $this->db->get_where('noticeboard',array('school_id'=>$this->session->userdata('school')))->result_array();
        $page_data['page_name']  = 'noticeboard';
        $page_data['page_title'] = get_phrase('noticeboard');
        $this->db->where('id',$this->session->userdata('school'));
        $page_data['settings']   = $this->db->get('s_settings');
        $this->load->view('backend/index', $page_data);
        
    }
    
    /**********MANAGE DOCUMENT / home work FOR A SPECIFIC CLASS or ALL*******************/
    function document($do = '', $document_id = '')
    {
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        
        $page_data['page_name']  = 'manage_document';
        $page_data['page_title'] = get_phrase('manage_documents');
        $page_data['documents']  = $this->db->get_where('document',array('school_id'=>$this->session->userdata('school')))->result_array();
        $this->db->where('id',$this->session->userdata('school'));
        $page_data['settings']   = $this->db->get('s_settings');
        $this->load->view('backend/index', $page_data);
    }
    
    /* private messaging */

    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?student/message/message_read/' . $message_thread_code, 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?student/message/message_read/' . $param2, 'refresh');
        }

        if ($param1 == 'message_read') {
            $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
            $this->crud_model->mark_thread_messages_read($param2);
        }

        $page_data['message_inner_page_name']   = $param1;
        $page_data['page_name']                 = 'message';
        $page_data['page_title']                = get_phrase('private_messaging');
        $this->db->where('id',$this->session->userdata('school'));
        $page_data['settings']   = $this->db->get('s_settings');
        $this->load->view('backend/index', $page_data);
    }
    
    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($param1 == 'update_profile_info') {
            // $data['name']        = $this->input->post('name');
            // $data['email']       = $this->input->post('email');
            
            // $this->db->where('student_id', $this->session->userdata('student_id'));
            // $this->db->update('student', $data);

            $data['name']  = $this->input->post('name');
            $data_login['email'] = $this->input->post('email');
            
            $this->db->trans_start();
            $this->db->where('user_id', $this->session->userdata('student_id'));
            $this->db->where('school_id', $this->session->userdata('school'));
            $this->db->where('account',3);
            $this->db->update('credentials', $data_login);
            $this->db->where('student_id', $this->session->userdata('student_id'));
            $this->db->where('school_id', $this->session->userdata('school'));
            $this->db->update('student',$data);
            $this->db->trans_complete();


            $this->db->where('id',$this->session->userdata('school'));
            $school_name  = $this->db->get('s_settings')->row()->system_name;

            if(is_dir('uploads/'.$school_name.'/student_image') === false){
                mkdir('uploads/'.$school_name.'/student_image');
            }

            $stdid = explode('/',$this->session->userdata('student_id'));
            $pic_id = $stdid[1].'_'.$stdid[2].'_'.$stdid[3];

            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/'.$school_name.'/student_image/' . $pic_id . '.jpg');
            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            redirect(base_url() . 'index.php?student/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password') {
            $data['password']             = $this->input->post('password');
            $data['new_password']         = $this->input->post('new_password');
            $data['confirm_new_password'] = $this->input->post('confirm_new_password');
            
            $current_password = $this->db->get_where('credentials', array(
                'user_id' => $this->session->userdata('student_id'),
                'account'   => 3
            ))->row()->password;
            if ($current_password == substr(sha1($data['password']),0,10) && $data['new_password'] == $data['confirm_new_password']) {
                $this->db->where('user_id', $this->session->userdata('student_id'));
                $this->db->where('school_id', $this->session->userdata('school'));
                $this->db->where('account',3);
               
                $this->db->update('credentials', array(
                    'password' => substr(sha1($data['new_password']),0,10)
                ));

                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
            }
            redirect(base_url() . 'index.php?student/manage_profile/', 'refresh');
        }
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['name']  = $this->db->get_where('student', array(
            'student_id' => $this->session->userdata('student_id')
        ))->row()->name;
        $page_data['email']  = $this->db->get_where('credentials', array(
            'user_id' => $this->session->userdata('student_id'),
            'account' => 3
        ))->row()->email;
        $this->db->where('id',$this->session->userdata('school'));
        $page_data['settings']   = $this->db->get('s_settings');
        $this->load->view('backend/index', $page_data);
    }
    
    /*****************SHOW STUDY MATERIAL / for students of a specific class*******************/
    function study_material($task = "", $document_id = "")
    {
        if ($this->session->userdata('student_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        }
        
        $data['study_material_info']    = $this->crud_model->select_study_material_info_for_student();
        $data['page_name']              = 'study_material';
        $data['page_title']             = get_phrase('study_material');
        $this->db->where('id',$this->session->userdata('school'));
        $data['settings']   = $this->db->get('s_settings');
        $this->load->view('backend/index', $data);
    }

    function check_email_update($email,$id,$account)
    {
        $email_decode = urldecode($email);

        $id_decode = urldecode($id);


        $resp = $this->db->get_where('credentials',array('email'=>$email_decode,'user_id'=>$id_decode,'account'=>$account));
            if($resp->num_rows() > 0){
                $response['status'] = 'valid';//the email is correct and for the current user
                
            }else{
                $resp = $this->db->get_where('credentials',array('email'=>$email_decode));
                if($resp->num_rows() > 0){
                    $response['status'] = 'invalid';//the email is correct but exists
                }else{
                $response['status'] = 'valid'; //the email is valid for use
                }
            }

        echo json_encode($response);
    }
}