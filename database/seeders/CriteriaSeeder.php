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
            'criteria_name' => 'Kehadiran Dalam Latihan',
            'priority' => 1
        ]);

        Criteria::firstOrCreate([
            'criteria_name' => 'Kemampuan Menguasai Koreo Dance',
            'priority' => 2
        ]);

        Criteria::firstOrCreate([
            'criteria_name' => 'Pengalaman Mengikuti Lomba',
            'priority' => 3
        ]);

        Criteria::firstOrCreate([
            'criteria_name' => 'Lama Menjadi Atlet',
            'priority' => 4
        ]);

    }
}
