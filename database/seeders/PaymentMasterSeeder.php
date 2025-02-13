<?php

namespace Database\Seeders;

use App\Models\PaymentMaster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'description' => " untuk pembayaran tagihan dilakukan dengan beberapa langkah berikut
1. user melakukan pengajuan pembayaran tagihan yang akan di bayarkan
2. User memillih bank dari tujuan yang akan di transfer oleh user
3. user menginputkan data diri account yang digunakan sebagai akun pembayaran
4. User mengupload bukti pembayaran dengan mengirimkan foto struk bukti transfer yang di upload
5. admin akan memverifikasi pembayaran user
6. pembayaran tagihan selesai",
            'title' => 'Payment Info',
            'type' => 'payment-info'
        ];
        $master = PaymentMaster::create($data);
    }
}
