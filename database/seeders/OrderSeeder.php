<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            echo "Tidak ada produk! Jalankan DatabaseSeeder dulu.\n";
            return;
        }

        $startDate = Carbon::now()->subMonths(3);
        $endDate = Carbon::now();
        $currentDate = $startDate->copy();

        $names = [
            'Budi', 'Andi', 'Siti', 'Rina', 'Dedi', 'Agus', 'Eko', 'Rini', 'Dewi', 'Fajar',
            'Hendra', 'Irwan', 'Joko', 'Kartika', 'Lukman', 'Maya', 'Nanda', 'Oki', 'Putra', 'Qori',
            'Rizky', 'Sari', 'Tono', 'Udin', 'Vina', 'Wawan', 'Yani', 'Zaki', 'Adit', 'Bayu',
            'Citra', 'Dian', 'Erik', 'Fani', 'Gilang', 'Hana', 'Imam', 'Jeni', 'Kevin', 'Lina',
        ];

        $phones = ['0812', '0813', '0857', '0878', '0856', '0821', '0822', '0852', '0853', '0877'];

        $orderCount = 0;

        while ($currentDate->lte($endDate)) {
            // Jumlah order per hari bervariasi: weekday 5-12, weekend 10-20
            $isWeekend = $currentDate->isWeekend();
            $ordersToday = $isWeekend ? rand(10, 20) : rand(5, 12);

            // Jam ramai: malam lebih banyak (warkop 24 jam)
            $hourWeights = [
                0 => 3, 1 => 2, 2 => 1, 3 => 1, 4 => 0, 5 => 0,
                6 => 1, 7 => 2, 8 => 3, 9 => 3, 10 => 4, 11 => 5,
                12 => 6, 13 => 5, 14 => 4, 15 => 4, 16 => 5, 17 => 6,
                18 => 7, 19 => 8, 20 => 9, 21 => 10, 22 => 8, 23 => 5,
            ];

            for ($i = 0; $i < $ordersToday; $i++) {
                // Pilih jam berdasarkan weight
                $hour = $this->weightedRandom($hourWeights);
                $minute = rand(0, 59);

                $orderTime = $currentDate->copy()->setHour($hour)->setMinute($minute)->setSecond(rand(0, 59));

                // Skip jika waktu di masa depan
                if ($orderTime->gt(Carbon::now())) continue;

                $name = $names[array_rand($names)];
                $phone = $phones[array_rand($phones)] . rand(10000000, 99999999);
                $meja = 'Meja ' . rand(1, 15);

                // Random status (kebanyakan completed untuk data historis)
                $statusRoll = rand(1, 100);
                if ($statusRoll <= 75) $status = 'completed';
                elseif ($statusRoll <= 85) $status = 'processing';
                elseif ($statusRoll <= 92) $status = 'confirmed';
                elseif ($statusRoll <= 97) $status = 'pending';
                else $status = 'cancelled';

                // Pilih 1-5 produk random
                $itemCount = rand(1, 5);
                $selectedProducts = $products->random(min($itemCount, $products->count()));

                $subtotal = 0;
                $items = [];

                foreach ($selectedProducts as $product) {
                    $qty = rand(1, 3);
                    $itemSubtotal = $product->price * $qty;
                    $subtotal += $itemSubtotal;

                    $items[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_price' => $product->price,
                        'quantity' => $qty,
                        'subtotal' => $itemSubtotal,
                    ];
                }

                $order = Order::create([
                    'order_number' => 'WB' . $orderTime->format('Ymd') . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                    'customer_name' => $name,
                    'customer_phone' => $phone,
                    'customer_email' => null,
                    'customer_address' => $meja,
                    'notes' => rand(1, 5) == 1 ? 'Jangan terlalu pedas' : null,
                    'payment_method' => 'cash',
                    'status' => $status,
                    'subtotal' => $subtotal,
                    'delivery_fee' => 0,
                    'total' => $subtotal,
                    'created_at' => $orderTime,
                    'updated_at' => $orderTime,
                ]);

                foreach ($items as $item) {
                    OrderItem::create(array_merge($item, [
                        'order_id' => $order->id,
                        'created_at' => $orderTime,
                        'updated_at' => $orderTime,
                    ]));
                }

                $orderCount++;
            }

            $currentDate->addDay();
        }

        echo "Berhasil generate {$orderCount} pesanan dummy (3 bulan)!\n";
    }

    private function weightedRandom(array $weights): int
    {
        $totalWeight = array_sum($weights);
        $random = rand(1, $totalWeight);
        $current = 0;

        foreach ($weights as $key => $weight) {
            $current += $weight;
            if ($random <= $current) return $key;
        }

        return array_key_first($weights);
    }
}
