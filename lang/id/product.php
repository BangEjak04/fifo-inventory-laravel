<?php

declare(strict_types=1);

return [
    'model' => [
        'label' => 'Produk',
        'pluralLabel' => 'Produk',
    ],
    'columns' => [
        'name' => 'Nama',
        'type' => 'Jenis',
        'code' => 'Kode',
        'stock' => 'Stok',
        'created_at' => 'Dibuat pada',
        'updated_at' => 'Diubah pada',
    ],
    'enums' => [
        'type' => [
            'dry' => 'Kering',
            'wet' => 'Basah',
        ],
    ],

    'inbound' => [
        'model' => [
            'label' => 'Stok',
        ],
        'columns' => [
            'production_date' => 'Tanggal produksi',
            'session' => 'Sesi',
            'quantity_in' => 'Jumlah stok',
            'quantity_remaining' => 'Sisa stok',
            'barcode' => 'Barcode',
        ],
        'enums' => [
            'session' => [
                'morning' => 'Pagi',
                'afternoon' => 'Siang',
            ],
        ],
    ],
];
