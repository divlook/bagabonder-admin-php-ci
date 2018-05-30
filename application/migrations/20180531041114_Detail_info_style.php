<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Detail_info_style extends CI_Migration {

  public function up()
  {
    $this->dbforge->add_field(array(
      'idx' => array(
        'type' => 'INT',
        'constraint' => 11,
        'auto_increment' => TRUE,
      ),
      'category' => array(
        'type' => 'VARCHAR',
        'constraint' => '20',
        'unique' => TRUE,
      ),
      'input1' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => TRUE,
      ),
      'input2' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => TRUE,
      ),
      'input3' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => TRUE,
      ),
      'input4' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => TRUE,
      ),
      'input5' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => TRUE,
      ),
      'input6' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => TRUE,
      ),
      'input7' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => TRUE,
      ),
      'input8' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => TRUE,
      ),
      'input9' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => TRUE,
      ),
      'input10' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => TRUE,
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
    $this->dbforge->create_table('detail_info_style');
  }

  public function down()
  {
    $this->dbforge->drop_table('detail_info_style');
  }
}