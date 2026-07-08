<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPromoFieldsToTransaction extends Migration
{
    public function up()
    {
        $fields = [
            'biaya_jasa' => [
                'type'    => 'DOUBLE',
                'null'    => TRUE,
                'default' => 0,
                'after'   => 'ongkir'
            ],
            'voucher_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => TRUE,
                'after'      => 'biaya_jasa'
            ],
            'diskon_voucher' => [
                'type'    => 'DOUBLE',
                'null'    => TRUE,
                'default' => 0,
                'after'   => 'voucher_code'
            ],
            'free_mouse' => [
                'type'    => 'DOUBLE',
                'null'    => TRUE,
                'default' => 0,
                'after'   => 'diskon_voucher'
            ],
        ];

        $this->forge->addColumn('transaction', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('transaction', [
            'biaya_jasa', 
            'voucher_code', 
            'diskon_voucher', 
            'free_mouse'
        ]);
    }
}