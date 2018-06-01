<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Auth extends CI_Migration {

  public function up()
  {
    $this->dbforge->add_field(array(
      'idx' => array(
        'type' => 'INT',
        'constraint' => 11,
        'auto_increment' => TRUE,
      ),
      'user_idx' => array(
        'type' => 'INT',
        'constraint' => 11,
        'null' => FALSE,
      ),
      'access_token' => array(
        'type' => 'CHAR',
        'constraint' => 64,
        'null' => FALSE,
      ),
      'reg_date' => array(
        'type' => 'DATETIME',
        'null' => FALSE,
      ),
      'up_date' => array(
        'type' => 'DATETIME',
        'null' => TRUE,
      ),
    ));
    $this->dbforge->add_key('idx', TRUE);
    $this->dbforge->create_table('auth');
  }

  public function down()
  {
    $this->dbforge->drop_table('auth');
  }
}