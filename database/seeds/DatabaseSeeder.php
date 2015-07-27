<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Type;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $avt=[
            '1437634539.jpg',
            '1437106469.jpg',
            '1437106714.jpg',
            '1437106796.jpg',
            '1437106868.jpg',
            '1437622106.jpg',
            '1437808833.jpg',
            '1437809400.jpg',
        ];
      $faker=Faker\Factory::create();
        for($i=0,$j=32;$i<15;$i++,$j++){
                \App\Cd::create([
                'name'=>$faker->realText(15),
                'singer_id'=>$faker->numberBetween(32,46),
                'composer_id'=>$j,
                'format_id'=>$faker->numberBetween(1,4),
                'type_id'=>$faker->numberBetween(1,4),
                'description'=>$faker->text(200),
                'quantity'=>$faker->numberBetween(20,50),
                'buy_time'=>$faker->numberBetween(0,100),
                'status'=>1,
                'portal'=>$faker->randomElement($avt),
                'root_price'=>$faker->numberBetween(8,20),
                'price'=>$faker->numberBetween(8,20),
                'sale_off'=>$faker->numberBetween(0,10),
                'public_date'=>\Carbon\Carbon::today(),
                'created_at'=>\Carbon\Carbon::today(),
            ]);
        }
    }
}
