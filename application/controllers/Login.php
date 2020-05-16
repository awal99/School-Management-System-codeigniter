<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author : Zinnia Tech
 * 	12th June, 2018
 * 
 */

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
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

    //Default function, redirects to logged in user area
    public function index() {

        if ($this->session->userdata('admin_login') == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');

        if ($this->session->userdata('teacher_login') == 1)
            redirect(base_url() . 'index.php?teacher/dashboard', 'refresh');

        if ($this->session->userdata('student_login') == 1)
            redirect(base_url() . 'index.php?student/dashboard', 'refresh');

        if ($this->session->userdata('parent_login') == 1)
            redirect(base_url() . 'index.php?parents/dashboard', 'refresh');

        $this->load->view('backend/login');
    }

    //Ajax login function 
    function ajax_login() {
        $response = array();

        //Recieving post input of email, password from ajax request
        $email = $_POST["email"];
        $password = $_POST["password"];
        $school =  $_POST["school"];
        $response['submitted_data'] = $_POST;

               /* encrypt password */
        $password = substr(sha1( $password ) , 0,10);

        //Validating login
        $login_status = $this->validate_login($email, $password, $school);
        $response['login_status'] = $login_status;
        if ($login_status == 'success') {
            $response['redirect_url'] = '';
        }

        //Replying ajax request with validation response
        echo json_encode($response);
    }

    //Validating login from ajax request
    function validate_login($email = '', $password = '', $school='') {
        $credential = array('email' => $email, 'password' => $password, 'school_id' => $school);
        //check if selected school is active
        $check_school   =   $this->db->select('subscription')->from('s_settings')->where('id',$school)->get();
        $row = $check_school->row();
    if($row->subscription == 'active')
    {

        // Checking login credential 
       
        $query = $this->db->get_where('credentials', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if($row->account == 1){ //admin
                $this->session->set_userdata('admin_login', '1');
                $this->session->set_userdata('admin_id', $row->user_id);
                $this->session->set_userdata('login_user_id', $row->user_id);
               // $this->session->set_userdata('name', $row->name);
                $this->session->set_userdata('login_type', 'admin');
                $this->session->set_userdata('school', $row->school_id);

                $running = $this->db->get_where('s_settings',array('id'=>$row->school_id))->row()->running_year;
                $this->session->set_userdata('running_year', $running);
                return 'success'; 
            }
            if($row->account == 2){ //teacher
                $this->session->set_userdata('teacher_login', '1');
                $this->session->set_userdata('teacher_id', $row->user_id);
                $this->session->set_userdata('login_user_id', $row->user_id);
               // $this->session->set_userdata('name', $row->name);
                $this->session->set_userdata('login_type', 'teacher');
                $this->session->set_userdata('school', $row->school_id);
                $running = $this->db->get_where('s_settings',array('id'=>$row->school_id))->row()->running_year;
                $this->session->set_userdata('running_year', $running);
                return 'success';
            }
            if($row->account == 3){ //student
                $this->session->set_userdata('student_login', '1');
                $this->session->set_userdata('student_id', $row->user_id);
                $this->session->set_userdata('login_user_id', $row->user_id);
                //$this->session->set_userdata('name', $row->name);
                $this->session->set_userdata('login_type', 'student');
                $this->session->set_userdata('school', $row->school_id);
                $running = $this->db->get_where('s_settings',array('id'=>$row->school_id))->row()->running_year;
                $this->session->set_userdata('running_year', $running);
                return 'success';
            }
            if($row->account == 4){ //parent
                $this->session->set_userdata('parent_login', '1');
                $this->session->set_userdata('parent_id', $row->user_id);
                $this->session->set_userdata('login_user_id', $row->user_id);
               // $this->session->set_userdata('name', $row->name);
                $this->session->set_userdata('login_type', 'parent');
                $this->session->set_userdata('school', $row->school_id);
                $running = $this->db->get_where('s_settings',array('id'=>$row->school_id))->row()->running_year;
                $this->session->set_userdata('running_year', $running);
                return 'success';
            }
           
            
        }


        return 'invalid';
    }
    return 'disabled';
    }

    /*     * *DEFAULT NOR FOUND PAGE**** */

    function four_zero_four() {
        $this->load->view('four_zero_four');
    }

    // PASSWORD RESET BY EMAIL
    function forgot_password()
    {
        $this->load->view('backend/forgot_password');
    }

    function ajax_forgot_password()
    {
        $resp                   = array();
        $resp['status']         = 'false';
        $email                  = $_POST["email"];
        $reset_account_type     = '';
        //resetting user password here
        $npass = substr( md5( rand(100000000,20000000000) ) , 0,8);
        $new_password           =   substr( sha1( $npass ) , 0,10);

        // Checking credential for admin
        $query = $this->db->get_where('credentials', array('email'=>$email,'school_id'=>$this->session->userdata('school')));

        if ($query->num_rows() > 0) {
            $row = $query->row();
            if($row->account == 1){ //admin
                $reset_account_type     =   'admin';
                $this->db->where('email' , $email);
                $this->db->update('credentials' , array('password' => $new_password));
                $resp['status']         = 'true';
            }
            if($row->account == 2){ //teacher
                $reset_account_type     =   'teacher';
                $this->db->where('email' , $email);
                $this->db->update('credentials' , array('password' => $new_password));
                $resp['status']         = 'true';
            }
            if($row->account == 3){ //student
                $reset_account_type     =   'student';
                $this->db->where('email' , $email);
                $this->db->update('credentials' , array('password' => $new_password));
                $resp['status']         = 'true';
            }
            if($row->account == 4){ //parent
                $reset_account_type     =   'parent';
                $this->db->where('email' , $email);
                $this->db->update('credentials' , array('password' => $new_password));
                $resp['status']         = 'true';
            }
           // send new password to user email  
         $this->email_model->password_reset_email($new_password , $reset_account_type , $email);

        
            
        }

        $resp['submitted_data'] = $_POST;
        $resp['status']     =   'false';

         
 
         echo json_encode($resp);
    }
   

    /*     * *****LOGOUT FUNCTION ****** */

    function logout() {
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(base_url(), 'refresh');
    }

}
