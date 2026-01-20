<?php

namespace Database\Seeders;

use App\Service;
use App\ServiceAuth;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ServiceAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceAuth::create([
            'name'=>'envatoelements',
            'cookie'=>'',
            'uid'=>'',
            'pw'=>'',
            'status'=>'1',
            'email_raw'=>'',
            'detail_raw'=>''
        ]);
        ServiceAuth::create([
            'name'=>'freepik1',
            'cookie'=>'',
            'uid'=>'',
            'pw'=>'',
            'status'=>'1',
            'email_raw'=>'',
            'detail_raw'=>''
        ]);
        ServiceAuth::create([
            'name'=>'freepik2',
            'cookie'=>'',
            'uid'=>'',
            'pw'=>'',
            'status'=>'1',
            'email_raw'=>'',
            'detail_raw'=>''
        ]);
        ServiceAuth::create([
            'name'=>'freepik3',
            'cookie'=>'',
            'uid'=>'',
            'pw'=>'',
            'status'=>'1',
            'email_raw'=>'',
            'detail_raw'=>''
        ]);
        ServiceAuth::create([
            'name'=>'motionarray',
            'cookie'=>'',
            'uid'=>'',
            'pw'=>'',
            'status'=>'1',
            'email_raw'=>'',
            'detail_raw'=>''
        ]);
        ServiceAuth::create([
            'name'=>'motionelements',
            'cookie'=>'',
            'uid'=>'',
            'pw'=>'',
            'status'=>'1',
            'email_raw'=>'',
            'detail_raw'=>''
        ]);
    }
}
