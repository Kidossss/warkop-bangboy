<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class VariantSeeder extends Seeder
{
    public function run(): void
    {
        ProductVariant::truncate();

        // Data variant: nama produk => [panas, dingin]
        $variants = [
            'Kopi Saring Hitam'       => ['Panas' => 7000, 'Dingin' => 8000],
            'Kopi Saring Susu'        => ['Panas' => 8000, 'Dingin' => 9000],
            'ABC Klepon'              => ['Panas' => 7000, 'Dingin' => 8000],
            'Gooday Cappucino'        => ['Panas' => 6000, 'Dingin' => 7000],
            'Gooday Freez'            => ['Panas' => 7000, 'Dingin' => 8000],
            'Variant Goodday'         => ['Panas' => 6000, 'Dingin' => 7000],
            'Milo'                    => ['Panas' => 7000, 'Dingin' => 8000],
            'Dancow'                  => ['Panas' => 8000, 'Dingin' => 9000],
            'Ovaltine'                => ['Panas' => 8000, 'Dingin' => 9000],
            'Frisian Flag'            => ['Panas' => 8000, 'Dingin' => 9000],
            'XJoss/Kuku Bima'         => ['Panas' => 6000, 'Dingin' => 7000],
            'XJoss/Kuku Bima Susu'    => ['Panas' => 7000, 'Dingin' => 8000],
            'Caffino'                 => ['Panas' => 7000, 'Dingin' => 8000],
            'Teh Tarik'               => ['Panas' => 6000, 'Dingin' => 7000],
            'Chocolatos'              => ['Panas' => 7000, 'Dingin' => 8000],
            'Drink Beng-Beng'         => ['Panas' => 7000, 'Dingin' => 8000],
            'Hilo'                    => ['Panas' => 8000, 'Dingin' => 9000],
            'Kapal/Luwak/ABC'         => ['Panas' => 5000, 'Dingin' => 6000],
            'Teh Manis'               => ['Panas' => 4000, 'Dingin' => 5000],
            'Teh Tawar'               => ['Panas' => 3000, 'Dingin' => 4000],
        ];

        $panasOnly = [
            'Jahe'       => ['Panas' => 5000],
            'Jahe Susu'  => ['Panas' => 7000],
        ];

        $dinginOnly = [
            'Soda/Fanta Susu'            => ['Dingin' => 13000],
            'Nutrisari All Variant'      => ['Dingin' => 5000],
            'Nutrisari All Variant Susu' => ['Dingin' => 7000],
            'Aqua Botol'                 => ['Dingin' => 5000],
        ];

        $count = 0;

        foreach ($variants as $name => $prices) {
            $product = Product::where('name', $name)->first();
            if ($product) {
                foreach ($prices as $variantName => $price) {
                    ProductVariant::create(['product_id' => $product->id, 'name' => $variantName, 'price' => $price]);
                    $count++;
                }
            } else {
                echo "Produk tidak ditemukan: {$name}\n";
            }
        }

        foreach ($panasOnly as $name => $prices) {
            $product = Product::where('name', $name)->first();
            if ($product) {
                foreach ($prices as $variantName => $price) {
                    ProductVariant::create(['product_id' => $product->id, 'name' => $variantName, 'price' => $price]);
                    $count++;
                }
            }
        }

        foreach ($dinginOnly as $name => $prices) {
            $product = Product::where('name', $name)->first();
            if ($product) {
                foreach ($prices as $variantName => $price) {
                    ProductVariant::create(['product_id' => $product->id, 'name' => $variantName, 'price' => $price]);
                    $count++;
                }
            }
        }

        echo "Berhasil insert {$count} variant!\n";
    }
}
