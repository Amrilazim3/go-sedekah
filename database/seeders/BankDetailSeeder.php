<?php

namespace Database\Seeders;

use App\Models\BankDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banksCode = [
            "Affin Bank Berhad" => "PHBMMYKL",
            "AGROBANK" => "BPMBMYKL",
            "Alliance Bank Malaysia Berhad" => "MFBBMYKL",
            "AL RAJHI BANKING & INVESTMENT CORPORATION (MALAYSIA) BERHAD" => "RJHIMYKL",
            "AmBank (M) Berhad" => "ARBKMYKL",
            "Bank Islam Malaysia Berhad" => "BIMBMYKL", 
            "Bank Kerjasama Rakyat Malaysia Berhad" => "BKRMMYKL", 
            "Bank Muamalat (Malaysia) Berhad" => "BMMBMYKL", 
            "Bank Simpanan Nasional Berhad" => "BSNAMYK1", 
            "CIMB Bank Berhad" => "CIBBMYKL", 
            "Citibank Berhad" => "CITIMYKL", 
            "Hong Leong Bank Berhad" => "HLBBMYKL", 
            "HSBC Bank Malaysia Berhad" => "HBMBMYKL", 
            "Kuwait Finance House" => "KFHOMYKL", 
            "Maybank" => "MBBEMYKL", 
            "OCBC Bank (Malaysia) Berhad" => "OCBCMYKL", 
            "Public Bank Berhad" => "PBBEMYKL", 
            "RHB Bank Berhad" => "RHBBMYKL", 
            "Standard Chartered Bank (Malaysia) Berhad" => "SCBLMYKX", 
            "United Overseas Bank (Malaysia) Berhad" => "UOVBMYKL", 
        ];

        foreach ($banksCode as $name => $code) {
            BankDetail::create([
                'name' => $name,
                'code' => $code,
            ]);
        }
    }
}
