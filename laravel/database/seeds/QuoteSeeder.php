<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Quote;

class QuoteSeeder extends Seeder
{
    const NUM_MODELS_TO_SEED = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = self::NUM_MODELS_TO_SEED;
        for ($x = $count; $x > 0; --$x) {

            // work out `created_at` date to set in Quote model
            $date = new DateTime();
            // days into the past to set the Quote model's `created_at` date to
            $date->sub(new DateInterval(sprintf('P%dD', $x)));
            // format date for db column value
            $created_at = $date->format('Y-m-d H:i:s');

            factory(Quote::class)->create(['created_at' => $created_at]);
        }
    }
}
