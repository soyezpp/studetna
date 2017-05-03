<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authcheck
{
    private $CI;

    function __construct()
    {
        // Assign by reference with "&" so we don't create a copy
        $this->CI = &get_instance();
    }

    public function is_admin()
    {
        if (!$this->CI->session->userdata('admin_id'))
            return false;
        return true;
    }

    public function check_is_admin()
    {
        if (!$this->is_admin())
        {
            redirect('auth/login', 'refresh');
            return;
        }
        else
            return $this->CI->session->userdata('admin_id');
    }

}