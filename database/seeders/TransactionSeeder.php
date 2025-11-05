<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada user untuk testing
        $user = User::first();
        
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Data dummy transaksi untuk testing
        $transactions = [
            // Pemasukan
            [
                'user_id' => $user->id,
                'type' => 'income',
                'title' => 'Gaji Bulanan',
                'description' => 'Gaji bulan November 2024 dari perusahaan',
                'amount' => 8000000,
                'category' => 'Gaji',
                'transaction_date' => now()->subDays(5),
            ],
            [
                'user_id' => $user->id,
                'type' => 'income',
                'title' => 'Bonus Kinerja',
                'description' => 'Bonus kinerja Q3 2024',
                'amount' => 2000000,
                'category' => 'Bonus',
                'transaction_date' => now()->subDays(10),
            ],
            [
                'user_id' => $user->id,
                'type' => 'income',
                'title' => 'Freelance Project',
                'description' => 'Pembayaran project website untuk klien',
                'amount' => 3500000,
                'category' => 'Freelance',
                'transaction_date' => now()->subDays(15),
            ],
            [
                'user_id' => $user->id,
                'type' => 'income',
                'title' => 'Dividen Investasi',
                'description' => 'Dividen dari investasi saham',
                'amount' => 500000,
                'category' => 'Investasi',
                'transaction_date' => now()->subDays(20),
            ],

            // Pengeluaran
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Belanja Bulanan',
                'description' => 'Belanja kebutuhan rumah tangga di supermarket',
                'amount' => 1500000,
                'category' => 'Belanja',
                'transaction_date' => now()->subDays(3),
            ],
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Bayar Listrik',
                'description' => 'Tagihan listrik bulan Oktober 2024',
                'amount' => 450000,
                'category' => 'Utilitas',
                'transaction_date' => now()->subDays(7),
            ],
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Bayar Air PDAM',
                'description' => 'Tagihan air bulan Oktober 2024',
                'amount' => 150000,
                'category' => 'Utilitas',
                'transaction_date' => now()->subDays(7),
            ],
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Internet & TV Kabel',
                'description' => 'Langganan internet dan TV kabel bulanan',
                'amount' => 500000,
                'category' => 'Utilitas',
                'transaction_date' => now()->subDays(8),
            ],
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Bensin Kendaraan',
                'description' => 'Isi bensin mobil untuk keperluan sehari-hari',
                'amount' => 300000,
                'category' => 'Transport',
                'transaction_date' => now()->subDays(2),
            ],
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Makan di Restoran',
                'description' => 'Makan malam keluarga di restoran',
                'amount' => 450000,
                'category' => 'Makanan',
                'transaction_date' => now()->subDays(4),
            ],
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Beli Buku',
                'description' => 'Membeli buku programming dan self-development',
                'amount' => 250000,
                'category' => 'Pendidikan',
                'transaction_date' => now()->subDays(6),
            ],
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Bayar Asuransi',
                'description' => 'Premi asuransi kesehatan bulanan',
                'amount' => 800000,
                'category' => 'Asuransi',
                'transaction_date' => now()->subDays(9),
            ],
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Servis Motor',
                'description' => 'Service rutin motor dan ganti oli',
                'amount' => 200000,
                'category' => 'Transport',
                'transaction_date' => now()->subDays(11),
            ],
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Beli Baju',
                'description' => 'Membeli baju kerja baru',
                'amount' => 350000,
                'category' => 'Fashion',
                'transaction_date' => now()->subDays(12),
            ],
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Langganan Streaming',
                'description' => 'Netflix dan Spotify premium',
                'amount' => 150000,
                'category' => 'Entertainment',
                'transaction_date' => now()->subDays(13),
            ],

            // Transaksi bulan lalu
            [
                'user_id' => $user->id,
                'type' => 'income',
                'title' => 'Gaji Bulanan',
                'description' => 'Gaji bulan Oktober 2024',
                'amount' => 8000000,
                'category' => 'Gaji',
                'transaction_date' => now()->subMonth()->subDays(5),
            ],
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Belanja Bulanan',
                'description' => 'Belanja kebutuhan bulanan Oktober',
                'amount' => 1400000,
                'category' => 'Belanja',
                'transaction_date' => now()->subMonth()->subDays(3),
            ],
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Bayar Listrik',
                'description' => 'Tagihan listrik September 2024',
                'amount' => 420000,
                'category' => 'Utilitas',
                'transaction_date' => now()->subMonth()->subDays(7),
            ],

            // Transaksi 2 bulan lalu
            [
                'user_id' => $user->id,
                'type' => 'income',
                'title' => 'Gaji Bulanan',
                'description' => 'Gaji bulan September 2024',
                'amount' => 8000000,
                'category' => 'Gaji',
                'transaction_date' => now()->subMonths(2)->subDays(5),
            ],
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Belanja Bulanan',
                'description' => 'Belanja kebutuhan bulanan September',
                'amount' => 1600000,
                'category' => 'Belanja',
                'transaction_date' => now()->subMonths(2)->subDays(3),
            ],

            // Tambahan untuk mencapai 25+ data (untuk testing pagination)
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Kopi & Snack',
                'description' => 'Beli kopi dan snack untuk kerja',
                'amount' => 75000,
                'category' => 'Makanan',
                'transaction_date' => now()->subDays(1),
            ],
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Parkir',
                'description' => 'Biaya parkir mall dan kantor',
                'amount' => 50000,
                'category' => 'Transport',
                'transaction_date' => now()->subDays(2),
            ],
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Top Up E-Money',
                'description' => 'Top up saldo e-wallet untuk pembayaran',
                'amount' => 200000,
                'category' => 'Transport',
                'transaction_date' => now()->subDays(5),
            ],
            [
                'user_id' => $user->id,
                'type' => 'income',
                'title' => 'Jual Barang Bekas',
                'description' => 'Jual laptop bekas yang sudah tidak terpakai',
                'amount' => 2500000,
                'category' => 'Lain-lain',
                'transaction_date' => now()->subDays(18),
            ],
            [
                'user_id' => $user->id,
                'type' => 'expense',
                'title' => 'Donasi',
                'description' => 'Donasi untuk kegiatan sosial',
                'amount' => 100000,
                'category' => 'Sosial',
                'transaction_date' => now()->subDays(14),
            ],
        ];

        // Insert semua data
        foreach ($transactions as $transaction) {
            Transaction::create($transaction);
        }

        echo "✅ Berhasil menambahkan " . count($transactions) . " transaksi dummy!\n";
        echo "👤 User: {$user->email}\n";
        echo "🔑 Password: password\n";
    }
}