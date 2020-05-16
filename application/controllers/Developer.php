<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*	
 *	@author 	: Zinnia Tech
 *	date		: 11 june, 2018
 */

class Developer extends CI_Controller
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
    
    /***default functin, redirects to login page if no logged in yet***/
    public function index()
    {
        //if ($this->session->userdata('login') != 1)
        //    redirect(base_url().'index.php?developer/login', 'refresh');
        
    }

    /**** LOGIN FOR DEVELOPER */

    public function login()
    {

    }

    public function logout()
    {

    }
    /**** DEVELOPER PAGE */

    public function main_page()
    {
        $page_data['page_name']  = 'developer';
        $page_data['page_title'] = get_phrase('developer_page');
        $this->load->view('backend/developer/developer', $page_data);
    }

/*** MODAL LOADER */
    function popup($page_name = '' , $param2 = '' , $param3 = '')
	{
		$account_type		=	$this->session->userdata('login_type');
		$page_data['param2']		=	$param2;
		$page_data['param3']		=	$param3;
		$this->load->view( 'backend/developer/'.$page_name.'.php' ,$page_data);
		
		echo '<script src="assets/js/neon-custom-ajax.js"></script>';
    }
    

    /***MANAGE ADMINISTRATORS OF VARIOUS SCHOOLS */

    public function admin($param1='',$param2='',$param3='')
    {
        if($param1=='create')
        {
           
            $data['name']        = $this->input->post('name');
            $data_login['email']       = $this->input->post('email');
            $data_login['password']    = substr(sha1($this->input->post('password')),0,10);
            $data_login['school_id']   = $this->input->post('school');
            $user_id     = $this->db->select('max(id)+1 as id')->from('credentials')->get()->row()->id;
            if($user_id == null){
                $user_id = 1;
            }
            $data_login['user_id'] = $user_id;
            $data_login['account']  = 1;
            
            $data['school_id']  = $data_login['school_id'];
            $data['admin_id']   = $data_login['user_id'];
            $this->db->trans_start();
            $this->db->insert('credentials', $data_login);
            $this->db->insert('admin',$data);
            $this->db->trans_complete();
            $this->session->set_flashdata('flash_message' ,'Admin Added Successfully' );
            redirect(base_url() . 'index.php?developer/main_page/', 'refresh');
         
        }

        if($param1=='edit')
        {

        }

        if($param1=='delete')
        {

        }
    }


    /*** edit SYSTEM_SETTINGS */

    public function system_settings_edit()
    {

        $page_data['page_name']  = 'developer';
        $page_data['page_title'] = get_phrase('developer_page');
        $this->load->view('backend/developer/developer', $page_data);
    }

    /** CREATE/ADD/EDIT/DELETE NEW SCHOOL */

    public function school($param1='',$param2='',$param3='')
    {
        if($param1=='create')
        {
            $resp = $this->db->get_where('s_settings',array('system_name' => $this->input->post('system_name')));

            if($resp->num_rows() <= 0)
            {
                $data['system_name']            =           $this->input->post('system_name');
                $data['system_title']           =           $this->input->post('system_title');
                $data['address']                =           $this->input->post('address');
                $data['phone']                  =           $this->input->post('phone');
                $data['paypal_email']           =           $this->input->post('paypal_email');
                $data['currency']               =           $this->input->post('currency');
                $data['system_email']           =           $this->input->post('system_email');
               // $data['active_sms_service']     =           $this->input->post('');
                $data['language']               =           $this->input->post('language');
                $data['text_align']             =           $this->input->post('text_align');
                //$data['skin_colour']
                //$data['subscription']
                $this->db->trans_start();
                $this->db->insert('s_settings', $data);
                $this->db->trans_complete();

                $this->session->set_flashdata('flash_message' , get_phrase('school_added')); 
                redirect(base_url() . 'index.php?developer/main_page/', 'refresh');
            }
            $this->session->set_flashdata('flash_message' , get_phrase('school_already_exists')); 
            redirect(base_url() . 'index.php?developer/main_page/', 'refresh');
        }

        if($param1=='edit')
        {

        }

        if($param1=='delete')
        {

        }

        if($param1=='subscription')
        {
            $this->db->where('id',$param2);
            $this->db->set('subscription',$this->input->post('subscription'));
            $this->db->update('s_settings');

            if($this->input->post('subscription')=='active')
            $this->session->set_flashdata('flash_message' , get_phrase('school_activated')); 
            else
            $this->session->set_flashdata('flash_message' , get_phrase('school_disabled')); 

            redirect(base_url() . 'index.php?developer/main_page/', 'refresh');

        }

        if($param1=='upload_logo')
        {
            if(move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png')==true)
            {
                $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            }
                $this->session->set_flashdata('flash_message', "error uploading pic");
            redirect(base_url() . 'index.php?developer/developer/', 'refresh');
        }
    }

    /*****BACKUP / RESTORE / DELETE DATA PAGE**********/
    function backup_restore($operation = '', $type = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($operation == 'create') {
            $this->crud_model->create_backup($type);
        }
        if ($operation == 'restore') {
            $this->crud_model->restore_backup();
            $this->session->set_flashdata('backup_message', 'Backup Restored');
            redirect(base_url() . 'index.php?admin/backup_restore/', 'refresh');
        }
        if ($operation == 'delete') {
            $this->crud_model->truncate($type);
            $this->session->set_flashdata('backup_message', 'Data removed');
            redirect(base_url() . 'index.php?admin/backup_restore/', 'refresh');
        }
        
        $page_data['page_info']  = 'Create backup / restore from backup';
        $page_data['page_name']  = 'backup_restore';
        $page_data['page_title'] = get_phrase('manage_backup_restore');
        $this->load->view('backend/index', $page_data);
    }
    
    
}