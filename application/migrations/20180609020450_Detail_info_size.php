<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Detail_info_size extends CI_Migration {

  public function up()
  {
    $fields = array(
      'rowname' => array(
        'type' => 'VARCHAR',
        'constraint' => '10',
        'null' => FALSE,
      ),
    );
    $this->dbforge->add_column('detail_info_size', $fields);
  }

  public function down()
  {
    $this->dbforge->drop_column('detail_info_size', 'rowname');
  }
}