<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller
{

    public function index()
    {
        redirect('user/listing');
    }

    /**
     * BO
     */
    public function listing($order = 'ASC')
    {

        $this->authcheck->check_is_admin();

        $this->load->model("resident_model");
        $this->load->model("correspondant_model");


        $data['title']        = "Liste des user";
        $data['order']        = $order;
        $data['all_user'] = $this->user_model->order_by('mail', $order)->get_all();


        $this->load->view('bo/templates/head', $data);
        $this->load->view('bo/user/user_listing_view', $data);
        $this->load->view('bo/templates/foot', $data);
    }

    public function add()
    {
        $this->authcheck->check_is_admin();

        $this->load->model("user_model");
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('<div class="btn btn-danger form-control">', '</div>');

        $this->form_validation->set_rules('mail', 'Mail', 'required|trim');
        $this->form_validation->set_rules('mdp', 'Mot de passe', 'trim');

        if ($this->form_validation->run() !== FALSE)
        {

            $postdata["mail"]         = $this->input->post('mail');
            $postdata["mdp"]      = $this->input->post('mdp');
            $resident_id             = $this->resident_model->insert($postdata);
            unset($postdata);
            $postdata["mail"]       = $this->input->post('mail');
            $postdata["user_id"] = $user_id;

            redirect('user/edit/'.$user_id);
        }



        $data['title'] = "Création d'un user";

        $this->load->view('bo/templates/head', $data);
        $this->load->view('bo/user/user_form_view', $data);
        $this->load->view('bo/templates/foot', $data);
    }

    /**
     * BO
     */
    public function edit($resident_id)
    {
        $this->authcheck->check_is_admin();
        $this->load->model("resident_model");
        $this->load->model("correspondant_model");

        $resident = $this->resident_model->get_by(array('id' => $resident_id));

        if (!$resident)
            show_404();

        $correspondant_principal = $this->correspondant_model->get_by(array('resident_id' => $resident_id, 'type' => 'principal'));

        if (!$correspondant_principal)
            show_404();

        $correspondants = $this->correspondant_model->get_many_by(array('resident_id' => $resident_id, 'type' => 'secondaire'));

        $this->form_validation->set_rules('nom', 'Nom', 'required|trim');
        $this->form_validation->set_rules('prenom', 'Prenom', 'trim');
        $this->form_validation->set_rules('email', 'Email', 'trim');
        $this->form_validation->set_rules('email_principal', 'Email principal', 'trim');

        if ($this->form_validation->run() !== FALSE)
        {
            $postdata["nom"]    = $this->input->post('nom');
            $postdata["prenom"] = $this->input->post('prenom');
            $this->resident_model->update($resident_id, $postdata);
            unset($postdata);

            $postdata["email"]       = $this->input->post('email_principal');
            $postdata["type"]        = 'principal';
            $postdata["resident_id"] = $resident_id;
            $this->correspondant_model->update($correspondant_principal->id, $postdata);
            unset($postdata);

            $this->correspondant_model->delete_by(array('resident_id' => $resident_id, 'type' => 'secondaire'));
            if (is_array($this->input->post('email_secondaire')))
            {
                foreach ($this->input->post('email_secondaire') as $correspondant_secondaire_update)
                {
                    $postdata["email"]       = $correspondant_secondaire_update;
                    $postdata["type"]        = 'secondaire';
                    $postdata["resident_id"] = $resident_id;
                    $this->correspondant_model->insert($postdata);
                    unset($postdata);
                }
            }

            if (!empty($this->input->post('email')))
            {
                $postdata["email"]       = $this->input->post('email');
                $postdata["type"]        = 'secondaire';
                $postdata["resident_id"] = $resident_id;
                $this->correspondant_model->insert($postdata);
            }



            redirect('resident/edit/'.$resident_id);
        }

        $data['title']                   = "Gestion du resident ".$resident->nom." ".$resident->prenom;
        $data['resident']                = $resident;
        $data['correspondants']          = $correspondants;
        $data['correspondant_principal'] = $correspondant_principal;
        $this->load->view('bo/templates/head', $data);
        $this->load->view('bo/resident/resident_form_view', $data);
        $this->load->view('bo/templates/foot', $data);
    }

    /**
     * BO
     */
    public function del_all($resident_id)
    {
        $this->authcheck->check_is_admin();

        $this->load->model('resident_model');
        $this->load->model("correspondant_model");


        $resident = $this->resident_model->get_by(array('id' => $resident_id));
        if (!$resident)
            show_404();

        $this->correspondant_model->delete_by(array('resident_id' => $resident_id));
        $this->resident_model->delete($resident_id);
        redirect('resident/listing');
    }

    public function del_one_correspondant($correspondant_id)
    {
        $this->authcheck->check_is_admin();

        $this->load->model("correspondant_model");


        $correspondant = $this->correspondant_model->get($correspondant_id);
        if (!$correspondant)
            show_404();

        $resident_id = $correspondant->resident_id;

        $this->correspondant_model->delete($correspondant_id);
        redirect('resident/edit/'.$resident_id);
    }

}