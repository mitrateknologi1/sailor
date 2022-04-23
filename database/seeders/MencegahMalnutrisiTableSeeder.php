<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MencegahMalnutrisiTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mencegah_malnutrisi')->delete();
        
        \DB::table('mencegah_malnutrisi')->insert(array (
            0 => 
            array (
                'id' => '15809a86-93d3-4735-8389-689ead47fb15',
                'randa_kabilasa_id' => '6eb6f3bf-69cf-499c-bc08-ac0b2f6388b1',
                'lingkar_lengan_atas' => 80.0,
                'tinggi_badan' => 160.0,
                'berat_badan' => 200.0,
                'created_at' => '2022-04-20 15:53:26',
                'updated_at' => '2022-04-20 15:53:26',
            ),
            1 => 
            array (
                'id' => '1969e5e7-d1c8-408e-8db7-8be384691a8e',
                'randa_kabilasa_id' => 'f9296b8e-98c3-4d73-971c-85c1d8260b8a',
                'lingkar_lengan_atas' => 20.0,
                'tinggi_badan' => 160.0,
                'berat_badan' => 30.0,
                'created_at' => '2022-04-20 15:26:02',
                'updated_at' => '2022-04-20 15:32:51',
            ),
            2 => 
            array (
                'id' => '4778e1cc-fc8b-4e16-9bb9-7196266bb90e',
                'randa_kabilasa_id' => '05c81592-c703-47a7-afa5-1d6cb4fe7d96',
                'lingkar_lengan_atas' => 10.0,
                'tinggi_badan' => 160.0,
                'berat_badan' => 40.0,
                'created_at' => '2022-04-20 15:39:22',
                'updated_at' => '2022-04-20 15:39:22',
            ),
            3 => 
            array (
                'id' => '58e5f6c2-e961-4f52-9ecd-b05ad417bd77',
                'randa_kabilasa_id' => 'ceead75b-7e43-42ae-8244-e05348f51f32',
                'lingkar_lengan_atas' => 24.0,
                'tinggi_badan' => 160.0,
                'berat_badan' => 50.0,
                'created_at' => '2022-04-20 15:41:01',
                'updated_at' => '2022-04-20 15:41:01',
            ),
            4 => 
            array (
                'id' => '9486b401-29be-4601-a1f1-ce8baa9e75f8',
                'randa_kabilasa_id' => '91a495b6-05a7-4d85-97ed-db43aa569dd8',
                'lingkar_lengan_atas' => 24.0,
                'tinggi_badan' => 160.0,
                'berat_badan' => 50.0,
                'created_at' => '2022-04-20 15:26:49',
                'updated_at' => '2022-04-20 15:26:49',
            ),
            5 => 
            array (
                'id' => '9959d535-4543-42d4-8739-bac2de6867bd',
                'randa_kabilasa_id' => '4dbaff89-0515-4c26-875c-87e083513add',
                'lingkar_lengan_atas' => 10.0,
                'tinggi_badan' => 160.0,
                'berat_badan' => 45.0,
                'created_at' => '2022-04-20 15:38:57',
                'updated_at' => '2022-04-20 15:52:17',
            ),
            6 => 
            array (
                'id' => 'b026cf80-1d66-4ffa-8e51-988fccb05d06',
                'randa_kabilasa_id' => '9b73f115-d9cb-48dd-a834-96dec3cffb0a',
                'lingkar_lengan_atas' => 24.0,
                'tinggi_badan' => 160.0,
                'berat_badan' => 65.0,
                'created_at' => '2022-04-20 15:40:13',
                'updated_at' => '2022-04-20 15:51:41',
            ),
            7 => 
            array (
                'id' => 'be860a5a-ea37-41ce-b730-3bdbd1054445',
                'randa_kabilasa_id' => '44b98ef8-f702-4fcd-a87b-f1bf0bd960a6',
                'lingkar_lengan_atas' => 20.0,
                'tinggi_badan' => 160.0,
                'berat_badan' => 200.0,
                'created_at' => '2022-04-20 15:36:48',
                'updated_at' => '2022-04-20 15:36:48',
            ),
            8 => 
            array (
                'id' => 'ebdabf1d-5664-4d7c-85fb-3fbfdc62d4e9',
                'randa_kabilasa_id' => '1709b6a1-de97-49d2-9a6e-2869ec5344a7',
                'lingkar_lengan_atas' => 24.0,
                'tinggi_badan' => 160.0,
                'berat_badan' => 65.0,
                'created_at' => '2022-04-20 15:27:57',
                'updated_at' => '2022-04-20 15:30:16',
            ),
        ));
        
        
    }
}