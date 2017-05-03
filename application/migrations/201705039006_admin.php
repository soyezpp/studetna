<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Admin extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
                'id'       => array(
                        'type'           => 'INT',
                        'constraint'     => 11,
                        'auto_increment' => TRUE,
                ),
                'prenom'   => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '255',
                ),
                'nom'      => array(
                        'type'       => 'VARCHAR',
                        'constraint' => '255',
                ),
                'commentaire' => array(
                        'type'       => 'TEXT',
                ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('admin');
    }

    public function down()
    {
        $this->dbforge->drop_table('admin');
    }

}