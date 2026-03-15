<?php

declare(strict_types=1);

return [
    'model' => [
        'label' => 'Product',
        'pluralLabel' => 'Products',
    ],
    'columns' => [
        'name' => 'Name',
        'type' => 'Type',
        'code' => 'Code',
        'stock' => 'Stock',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
    ],
    'enums' => [
        'type' => [
            'dry' => 'Dry',
            'wet' => 'Wet',
        ],
    ],

    'inbound' => [
        'model' => [
            'label' => 'Stock',
        ],
        'columns' => [
            'production_date' => 'Production date',
            'expired_date' => 'Expired date',
            'session' => 'Session',
            'quantity_in' => 'Stock amount',
            'quantity_remaining' => 'Remaining stock',
            'barcode' => 'Barcode',
        ],
        'enums' => [
            'session' => [
                'morning' => 'Morning',
                'afternoon' => 'Afternoon',
            ],
        ],
    ],

    'request' => [
        'model' => [
            'label' => 'Request',
        ],
        'columns' => [
            'type' => 'Type',
        ],
        'enums' => [
            'type' => [
                'sale' => 'Sale',
                'return' => 'Return',
                'remove' => 'Remove',
            ],
            'status' => [
                'draft' => 'Draft',
                'approved' => 'Approved',
                'processing' => 'Processing',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ],
        ],
    ],
];
