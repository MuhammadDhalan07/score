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


        // sub()( Criteria
        $kehadiranDalamLatihan = Criteria::where('criteria_name', 'Kehadiran Dalam Latihan')->first();
        $kehadiranDalamLatihan->sub()->createMany([
            [
                'criteria_name' => 'Sangat Baik',
                'priority' => 1
            ],
            [
                'criteria_name' => 'Baik',
                'priority' => 2
            ],
            [
                'criteria_name' => 'Cukup',
                'priority' => 3
            ],
            [
                'criteria_name' => 'Kurang',
                'priority' => 4
            ],
        ]);

        $menguasaiKoreo = Criteria::where('criteria_name', 'Kemampuan Menguasai Koreo Dance')->first();
        $menguasaiKoreo->sub()->createMany([
            [
                'criteria_name' => 'Sangat Baik',
                'priority' => 1
            ],
            [
                'criteria_name' => 'Baik',
                'priority' => 2
            ],
            [
                'criteria_name' => 'Cukup',
                'priority' => 3
            ],
            [
                'criteria_name' => 'Kurang',
                'priority' => 4
            ],
        ]);

        $pengalamanLomba = Criteria::where('criteria_name', 'Pengalaman Mengikuti Lomba')->first();
        $pengalamanLomba->sub()->createMany([
            [
                'criteria_name' => 'Sangat Baik',
                'priority' => 1
            ],
            [
                'criteria_name' => 'Baik',
                'priority' => 2
            ],
            [
                'criteria_name' => 'Cukup',
                'priority' => 3
            ],
            [
                'criteria_name' => 'Kurang',
                'priority' => 4
            ],
        ]);

        $lamaMenjadiAtlet = Criteria::where('criteria_name', 'Lama Menjadi Atlet')->first();
        $lamaMenjadiAtlet->sub()->createMany([
            [
                'criteria_name' => 'Sangat Baik',
                'priority' => 1
            ],
            [
                'criteria_name' => 'Baik',
                'priority' => 2
            ],
            [
                'criteria_name' => 'Cukup',
                'priority' => 3
            ],
            [
                'criteria_name' => 'Kurang',
                'priority' => 4
            ],
        ]);

    }
}
