<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function index()
    {
        redirect("auth/login");
    }

    public function login()
    {
        $this->load->library('authcheck');

        if ($this->authcheck->is_admin() == false)
        {
            $this->load->model('admin_model');
            $this->load->helper('security');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('mail', 'Mail', 'required|trim|valid_email');
            $this->form_validation->set_rules('mdp', 'Mot de Passe', 'required|trim');

            if ($this->form_validation->run() !== FALSE)
            {
                $password = do_hash($this->input->post('mdp'));
                if ($admin    = $this->admin_model->get_by(array('mail' => $this->input->post('mail'), 'mdp' => $password)))
                {
                    $this->session->set_userdata('admin_id', $admin->id);
                    redirect('admin/listing');
                }
                else
                {
                    $data['error'] = 'Mauvais e-mail ou mot de passe';
                }
            }

            $data['title'] = "Identification";
            $this->load->view('bo/templates/head', $data);
            $this->load->view('front/auth/auth_form_view', $data);
            $this->load->view('bo/templates/foot', $data);
        }
        else
        {
            redirect('admin/listing');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    ############################################################################
    ############################################################################
    ############################################################################

    public function get_new_password()
    {
        $this->load->model('admin_model');
        $this->load->model('resident_model');
        $this->load->helper('security');
        $this->load->helper('string');
        $this->load->library('form_validation');
        $this->load->library('email');

        $this->form_validation->set_rules('mail', 'mail', 'required|trim|valid_email');

        if ($this->form_validation->run() !== FALSE)
        {
            if ($admin = $this->admin_model->get_by(array('email' => $this->input->post('email'))))
            {
                $new_password    = random_string('alnum', 10);
                $postdata["mdp"] = do_hash($new_password);
                $this->admin_model->update($admin->id, $postdata);

                // si le message est saisi directement dans la méthode, ces vues ne servent à rien !
                $data["new_mdp"]      = $new_password;
                $emaildata["content"] = $this->load->view('bo/auth/auth_new_password_view', $data, TRUE);
                $emailcontent         = $this->load->view('bo/templates/template_email_view', $emaildata, TRUE);

                $this->email->from('noreply@melodhier.com', "Melodhier");
                $this->email->to($this->input->post('email'));

                $this->email->subject('Mot de passe réinitialisé');
                $this->email->message($emailcontent);
                $this->email->send();

                $this->session->set_flashdata('message', "<p class='alert alert-success text-center'>Nouveau mot de passe envoyé</p>");
                redirect('auth/login');
            }
            else
            {
                $this->session->set_flashdata('message', "<p class='alert alert-danger text-center'>Email inconnu</p>");
            }
        }
        $data['title'] = "Réinitialiser mon mot de passe";
        $this->load->view('bo/templates/head', $data);
        $this->load->view('bo/auth/auth_new_password_view', $data);
        $this->load->view('bo/templates/foot', $data);
    }

}