<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Detail_info_index extends CI_Migration {

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
        'constraint' => 20,
        'unique' => TRUE,
      ),
      'input_use' => array(
        'type' => 'INT',
        'constraint' => 11,
        'null' => FALSE,
      ),
      'rows_use' => array(
        'type' => 'INT',
        'constraint' => 11,
        'null' => FALSE,
      ),
      'image' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
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
    $this->dbforge->create_table('detail_info_index');
  }

  public function down()
  {
    $this->dbforge->drop_table('detail_info_index');
  }
}