<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Quote;

class QuoteSeeder extends Seeder
{
    const SEEDER_MODE_FAKE = 'fake';
    const SEEDER_MODE_REAL = 'real';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // fetch config params
        $count = env('NUM_MODELS_TO_SEED', 10);
        $mode  = env('SEEDER_MODE', self::SEEDER_MODE_FAKE);

        $mode === self::SEEDER_MODE_REAL ? 
            $this->seedRealData($count) : $this->seedFakeData($count);
    }

    protected function seedFakeData($count)
    {
        for ($x = 0; $x < $count; $x++) {
            $created_date = $this->getCreatedDate($count);

            if (false === $created_date) {
                return;
            }

            factory(Quote::class)->create([
                'created_at' => $created_date,
            ]);

        }
    }

    protected function seedRealData($count)
    {
        for ($x = 0; $x < $count; $x++) {
            $created_date = $this->getCreatedDate($count);

            if (false === $created_date) {
                return;
            }

            Artisan::call('rapidapi:fetch', [
                'created_date' => $created_date,
            ]);
            
            // The RapidAPI endpoint used for retrieving Quote data has a 
            // rate limit of 1 request per second. So let's hang around for a bit
            // before making another request.
            sleep(5); // to be on the safe side!
        }
    }

    /**
     * Works out the `created_at` date to set in the Quote model.
     * 
     * @return string
     */
    protected function getCreatedDate()
    {
        $quote = Quote::latest()->first();
        if ($quote instanceof Quote) {
            $date = new DateTime($quote->created_at);
            // modify date to 1 day into the past
            $date->add(new DateInterval('P1D')); // 'P1D': period of 1 day
        } else {
            $date = new DateTime();

            $date->sub(new DateInterval(sprintf('P%dD', $count))); // period of $count days
        }

        // check if created date to be set is today's date, and 
        // bail if it is. This is because we don't need any quotes 
        // newer than today.
        $today = new DateTime();
        
        if ($date->format('Y-m-d') == $today->format('Y-m-d')) {
            return false;
        }

        // format date for db column value
        $created_at = $date->format('Y-m-d H:i:s');
        
        return $created_at;
    }
}
