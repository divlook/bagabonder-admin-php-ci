<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_User extends CI_Migration {

  public function up()
  {
    $this->dbforge->add_field(array(
      'idx' => array(
        'type' => 'INT',
        'constraint' => 11,
        'auto_increment' => TRUE,
      ),
      'username' => array(
        'type' => 'VARCHAR',
        'constraint' => 20,
        'unique' => TRUE,
      ),
      'password' => array(
        'type' => 'CHAR',
        'constraint' => 64,
        'null' => FALSE,
      ),
      'level' => array(
        'type' => 'INT',
        'constraint' => 11,
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
      'del_date' => array(
        'type' => 'DATETIME',
        'null' => TRUE,
      ),
    ));
    $this->dbforge->add_key('idx', TRUE);
    $this->dbforge->create_table('user');
  }

  public function down()
  {
    $this->dbforge->drop_table('user');
  }
}