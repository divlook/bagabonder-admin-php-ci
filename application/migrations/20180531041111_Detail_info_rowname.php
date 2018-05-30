<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Detail_info_rowname extends CI_Migration {

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
      'rows1' => array(
        'type' => 'VARCHAR',
        'constraint' => 10,
        'null' => TRUE,
      ),
      'rows2' => array(
        'type' => 'VARCHAR',
        'constraint' => 10,
        'null' => TRUE,
      ),
      'rows3' => array(
        'type' => 'VARCHAR',
        'constraint' => 10,
        'null' => TRUE,
      ),
      'rows4' => array(
        'type' => 'VARCHAR',
        'constraint' => 10,
        'null' => TRUE,
      ),
      'rows5' => array(
        'type' => 'VARCHAR',
        'constraint' => 10,
        'null' => TRUE,
      ),
      'rows6' => array(
        'type' => 'VARCHAR',
        'constraint' => 10,
        'null' => TRUE,
      ),
      'rows7' => array(
        'type' => 'VARCHAR',
        'constraint' => 10,
        'null' => TRUE,
      ),
      'rows8' => array(
        'type' => 'VARCHAR',
        'constraint' => 10,
        'null' => TRUE,
      ),
      'rows9' => array(
        'type' => 'VARCHAR',
        'constraint' => 10,
        'null' => TRUE,
      ),
      'rows10' => array(
        'type' => 'VARCHAR',
        'constraint' => 10,
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
    $this->dbforge->create_table('detail_info_rowname');
  }

  public function down()
  {
    $this->dbforge->drop_table('detail_info_rowname');
  }
}