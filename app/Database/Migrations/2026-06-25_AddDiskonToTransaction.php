<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDiskonToTransaction extends Migration
{
    public function up()
    {
        $fields = [
            'diskon' => [
                'type'    => 'DOUBLE',
                'null'    => TRUE,
                'default' => 0,
                'after'   => 'ongkir'
            ],
            'persen_diskon' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => TRUE,
                'default'    => 0,
                'after'      => 'diskon'
            ],
        ];

        $this->forge->addColumn('transaction', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('transaction', ['diskon', 'persen_diskon']);
    }
}