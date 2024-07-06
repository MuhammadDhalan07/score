<?php

namespace Database\Seeders;

use App\Models\Grade\Criteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Laravel\Prompts\confirm;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $confirmed = confirm('Truncate Criteria?');

        Criteria::truncate($confirmed);

        Criteria::firstOrCreate([
            'criteria_name' => 'Mutu',
            'priority' => 1,
        ]);

        Criteria::firstOrCreate([
            'criteria_name' => 'Harga',
            'priority' => 2,

        ]);

        Criteria::firstOrCreate([
            'criteria_name' => 'Jumlah Penyakit Yang Dapat Di Basmi',
            'priority' => 3,

        ]);

        Criteria::firstOrCreate([
            'criteria_name' => 'Dosis Pestisida',
            'priority' => 4,

        ]);

    }
}
