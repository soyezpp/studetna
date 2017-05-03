<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller
{

    /**
     * BO
     */
    public function index()
    {

        redirect("admin/listing");
        $this->load->view('templates/foot', $data);
        $this->load->view('/templates/head', $data);
    }

    /**
     * BO
     */
    public function listing()
    {
        $this->authcheck->check_is_admin();

        $this->load->model("admin_model");
        $data['title']     = "Liste des administrateurs";
        $data['all_admin'] = $this->admin_model->get_all();
        $this->load->view('bo/templates/head', $data);
        $this->load->view('bo/admin/admin_listing_view', $data);
        $this->load->view('bo/templates/foot', $data);
    }

    /**
     * BO
     */
    public function add()
    {
        $this->authcheck->check_is_admin();

        $this->load->model('admin_model');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('<div class="btn btn-danger form-control">', '</div>');

        $this->form_validation->set_rules('mail', 'Mail', 'required|trim|valid_email');
        $this->form_validation->set_rules('mdp', 'Mot de passe', 'required|trim');

        if ($this->form_validation->run() !== FALSE)
        {

            $postdata["mail"]    = $this->input->post('mail');
            $postdata["mdp"]      = do_hash($this->input->post('mdp'));
            $this->admin_model->insert($postdata);
            redirect('admin/listing');
        }

        $data['title'] = "Ajouter un administrateur";
        $this->load->view('bo/templates/head', $data);
        $this->load->view('bo/admin/admin_form_view', $data);
        $this->load->view('bo/templates/foot', $data);
    }

    /**
     * BO
     * @param integer $admin_id
     */
    public function edit($admin_id)
    {
        $this->authcheck->check_is_admin();

        $this->load->model('admin_model');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('<div class="btn btn-danger">', '</div>');

        $admin = $this->admin_model->get_by(array('id' => $admin_id));
        if (!$admin)
            show_404();
        $this->form_validation->set_rules('mdp', 'Mdp', 'required|trim');
        $this->form_validation->set_rules('mail', 'Mail', 'required|trim|valid_email');

        if ($this->input->post('password') != "")
            $this->form_validation->set_rules('mdp', 'Mot de passe', 'required|trim');

        if ($this->form_validation->run() !== FALSE)
        {
            $postdata["mail"]    = $this->input->post('mail');

            if ($this->input->post('mdp') != "")
                $postdata["mdp"] = do_hash($this->input->post('mdp'));

            $this->admin_model->update($admin_id, $postdata);
            redirect('admin/listing');
        }


        $data["admin"] = $admin;
        $data['title'] = 'Modifier un administrateur';
        $this->load->view('bo/templates/head', $data);
        $this->load->view('bo/admin/admin_form_view', $data);
        $this->load->view('bo/templates/foot', $data);
    }

    /**
     * BO
     * @param integer $admin_id
     */
    public function del_confirm($admin_id)
    {
        $this->authcheck->check_is_admin();

        $this->load->model('admin_model');

        $admin = $this->admin_model->get_by(array('id' => $admin_id));
        if (!$admin)
            show_404();


        $data["admin"] = $admin;
        $data["title"] = 'Supprimer un administrateur';
        $this->load->view('templates/head', $data);
        $this->load->view('admin/admin_del_confirm_view', $data);
        $this->load->view('templates/foot', $data);
    }

    /**
     * BO
     * @param integer $admin_id
     */
    public function del($admin_id)
    {
        $this->authcheck->check_is_admin();

        $this->load->model('admin_model');

        $admin = $this->admin_model->get_by(array('id' => $admin_id));
        if (!$admin)
            show_404();

        $this->admin_model->delete($admin_id);
        redirect('admin/listing');
    }

}