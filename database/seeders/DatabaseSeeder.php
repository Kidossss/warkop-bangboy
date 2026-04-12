<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin Warkop',
            'email' => 'admin@warkopbangboy.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        // Kasir user
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@warkopbangboy.com',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir',
            'phone' => '081234567891',
        ]);

        // ==================== CATEGORIES ====================
        $minuman = Category::create(['name' => 'Aneka Minuman', 'slug' => 'aneka-minuman', 'description' => 'Aneka minuman panas dan dingin']);
        $signature = Category::create(['name' => 'Signature Warkop', 'slug' => 'signature-warkop', 'description' => 'Menu signature khas Warkop Bang Boy']);
        $indomie = Category::create(['name' => 'Indomie', 'slug' => 'indomie', 'description' => 'Aneka olahan Indomie']);
        $makanan = Category::create(['name' => 'Aneka Makanan', 'slug' => 'aneka-makanan', 'description' => 'Aneka makanan berat']);
        $cemilan = Category::create(['name' => 'Aneka Cemilan', 'slug' => 'aneka-cemilan', 'description' => 'Aneka cemilan dan snack']);

        // ==================== ANEKA MINUMAN ====================
        $minumanProducts = [
            ['name' => 'Soda/Fanta Susu', 'price' => 13000, 'description' => 'Dingin: Rp 13.000'],
            ['name' => 'Kopi Saring Hitam', 'price' => 8000, 'description' => 'Panas: Rp 7.000 | Dingin: Rp 8.000'],
            ['name' => 'Kopi Saring Susu', 'price' => 9000, 'description' => 'Panas: Rp 8.000 | Dingin: Rp 9.000'],
            ['name' => 'ABC Klepon', 'price' => 8000, 'description' => 'Panas: Rp 7.000 | Dingin: Rp 8.000'],
            ['name' => 'Gooday Cappucino', 'price' => 7000, 'description' => 'Panas: Rp 6.000 | Dingin: Rp 7.000'],
            ['name' => 'Gooday Freez', 'price' => 8000, 'description' => 'Panas: Rp 7.000 | Dingin: Rp 8.000'],
            ['name' => 'Variant Goodday', 'price' => 7000, 'description' => 'Panas: Rp 6.000 | Dingin: Rp 7.000'],
            ['name' => 'Milo', 'price' => 8000, 'description' => 'Panas: Rp 7.000 | Dingin: Rp 8.000'],
            ['name' => 'Dancow', 'price' => 9000, 'description' => 'Panas: Rp 8.000 | Dingin: Rp 9.000'],
            ['name' => 'Ovaltine', 'price' => 9000, 'description' => 'Panas: Rp 8.000 | Dingin: Rp 9.000'],
            ['name' => 'Frisian Flag', 'price' => 9000, 'description' => 'Panas: Rp 8.000 | Dingin: Rp 9.000'],
            ['name' => 'XJoss/Kuku Bima', 'price' => 7000, 'description' => 'Panas: Rp 6.000 | Dingin: Rp 7.000'],
            ['name' => 'XJoss/Kuku Bima Susu', 'price' => 8000, 'description' => 'Panas: Rp 7.000 | Dingin: Rp 8.000'],
            ['name' => 'Nutrisari All Variant', 'price' => 5000, 'description' => 'Dingin: Rp 5.000'],
            ['name' => 'Nutrisari All Variant Susu', 'price' => 7000, 'description' => 'Dingin: Rp 7.000'],
            ['name' => 'Caffino', 'price' => 8000, 'description' => 'Panas: Rp 7.000 | Dingin: Rp 8.000'],
            ['name' => 'Teh Tarik', 'price' => 7000, 'description' => 'Panas: Rp 6.000 | Dingin: Rp 7.000'],
            ['name' => 'Chocolatos', 'price' => 8000, 'description' => 'Panas: Rp 7.000 | Dingin: Rp 8.000'],
            ['name' => 'Drink Beng-Beng', 'price' => 8000, 'description' => 'Panas: Rp 7.000 | Dingin: Rp 8.000'],
            ['name' => 'Hilo', 'price' => 9000, 'description' => 'Panas: Rp 8.000 | Dingin: Rp 9.000'],
            ['name' => 'Jahe', 'price' => 5000, 'description' => 'Panas: Rp 5.000'],
            ['name' => 'Jahe Susu', 'price' => 7000, 'description' => 'Panas: Rp 7.000'],
            ['name' => 'Kapal/Luwak/ABC', 'price' => 6000, 'description' => 'Panas: Rp 5.000 | Dingin: Rp 6.000'],
            ['name' => 'Teh Manis', 'price' => 5000, 'description' => 'Panas: Rp 4.000 | Dingin: Rp 5.000'],
            ['name' => 'Teh Tawar', 'price' => 4000, 'description' => 'Panas: Rp 3.000 | Dingin: Rp 4.000'],
            ['name' => 'Aqua Botol', 'price' => 5000, 'description' => 'Dingin: Rp 5.000'],
        ];

        foreach ($minumanProducts as $p) {
            Product::create(array_merge($p, [
                'slug' => Str::slug($p['name']) . '-' . Str::random(5),
                'category_id' => $minuman->id,
                'is_available' => true,
                'image' => null,
            ]));
        }

        // ==================== SIGNATURE WARKOP ====================
        $signatureProducts = [
            ['name' => 'Chocolate', 'price' => 15000, 'description' => 'Minuman coklat signature Warkop Bang Boy'],
            ['name' => 'Taro', 'price' => 15000, 'description' => 'Minuman taro signature Warkop Bang Boy'],
            ['name' => 'Americano', 'price' => 12000, 'description' => 'Kopi americano signature Warkop Bang Boy'],
            ['name' => 'V60', 'price' => 18000, 'description' => 'Kopi V60 manual brew signature Warkop Bang Boy'],
        ];

        foreach ($signatureProducts as $p) {
            Product::create(array_merge($p, [
                'slug' => Str::slug($p['name']) . '-' . Str::random(5),
                'category_id' => $signature->id,
                'is_available' => true,
                'image' => null,
            ]));
        }

        // ==================== INDOMIE ====================
        $indomieProducts = [
            ['name' => 'Indomie Polos', 'price' => 8000, 'description' => 'Indomie goreng/kuah polos'],
            ['name' => 'Indomie Telor', 'price' => 12000, 'description' => 'Indomie dengan telur'],
            ['name' => 'Indomie Telor + Bakso/Kornet', 'price' => 16000, 'description' => 'Indomie dengan telur dan bakso atau kornet'],
            ['name' => 'Indomie Komplit (Internet)', 'price' => 20000, 'description' => 'Indomie komplit dengan telur, bakso/kornet, dan kerupuk'],
            ['name' => 'Indomie Special (Internet + Keju)', 'price' => 24000, 'description' => 'Indomie komplit spesial dengan tambahan keju'],
            ['name' => 'Indomie Double Polos', 'price' => 12000, 'description' => 'Indomie double porsi polos'],
            ['name' => 'Indomie Double Telor', 'price' => 16000, 'description' => 'Indomie double porsi dengan telur'],
            ['name' => 'Indomie Double Telor + Bakso/Kornet', 'price' => 20000, 'description' => 'Indomie double porsi dengan telur dan bakso atau kornet'],
            ['name' => 'Indomie Double Komplit', 'price' => 23000, 'description' => 'Indomie double porsi komplit dengan semua topping'],
            ['name' => 'Indomie TekTek Goreng/Kuah (Single)', 'price' => 15000, 'description' => 'Indomie tektek goreng atau kuah porsi single'],
        ];

        foreach ($indomieProducts as $p) {
            Product::create(array_merge($p, [
                'slug' => Str::slug($p['name']) . '-' . Str::random(5),
                'category_id' => $indomie->id,
                'is_available' => true,
                'image' => null,
            ]));
        }

        // ==================== ANEKA MAKANAN ====================
        $makananProducts = [
            ['name' => 'Nasi Goreng Bakso/Sosis', 'price' => 15000, 'description' => 'Nasi goreng dengan bakso atau sosis'],
            ['name' => 'Nasi Goreng Komplit', 'price' => 20000, 'description' => 'Nasi goreng komplit dengan telur dan topping lengkap'],
            ['name' => 'Omelet', 'price' => 15000, 'description' => 'Omelet telur polos'],
            ['name' => 'Omelet Bakso/Sosis', 'price' => 18000, 'description' => 'Omelet dengan isian bakso atau sosis'],
            ['name' => 'Omelet Komplit', 'price' => 22000, 'description' => 'Omelet dengan isian lengkap'],
            ['name' => 'Nasi Goreng Mawut', 'price' => 18000, 'description' => 'Nasi goreng mawut campur mie'],
            ['name' => 'Nasi Telur Dadar/Mata Sapi', 'price' => 10000, 'description' => 'Nasi putih dengan telur dadar atau mata sapi'],
        ];

        foreach ($makananProducts as $p) {
            Product::create(array_merge($p, [
                'slug' => Str::slug($p['name']) . '-' . Str::random(5),
                'category_id' => $makanan->id,
                'is_available' => true,
                'image' => null,
            ]));
        }

        // ==================== ANEKA CEMILAN ====================
        $cemilanProducts = [
            ['name' => 'Kentang Goreng', 'price' => 16000, 'description' => 'Kentang goreng crispy'],
            ['name' => 'Platter', 'price' => 22000, 'description' => 'Platter aneka cemilan'],
            ['name' => 'Dimsum', 'price' => 20000, 'description' => 'Dimsum kukus aneka rasa'],
            ['name' => 'Roti Kukus Choco/Butter Gula', 'price' => 9000, 'description' => 'Roti kukus dengan isian coklat atau butter gula'],
            ['name' => 'Roti Kukus Srikaya/Selai Kacang', 'price' => 10000, 'description' => 'Roti kukus dengan isian srikaya atau selai kacang'],
            ['name' => 'Otak Otak/Mipau Cokelat', 'price' => 10000, 'description' => 'Otak-otak atau mipau cokelat'],
            ['name' => 'Pisang Cokelat', 'price' => 10000, 'description' => 'Pisang goreng dengan topping cokelat'],
            ['name' => 'Cireng Rujak Goreng', 'price' => 15000, 'description' => 'Cireng goreng dengan saus rujak'],
        ];

        foreach ($cemilanProducts as $p) {
            Product::create(array_merge($p, [
                'slug' => Str::slug($p['name']) . '-' . Str::random(5),
                'category_id' => $cemilan->id,
                'is_available' => true,
                'image' => null,
            ]));
        }

        echo "Seeding selesai!\n";
        echo "Total menu: " . Product::count() . " item\n";
        echo "Admin: admin@warkopbangboy.com / admin123\n";
        echo "Kasir: kasir@warkopbangboy.com / kasir123\n";
    }
}