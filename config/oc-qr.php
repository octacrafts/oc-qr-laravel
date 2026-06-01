<?php

declare(strict_types=1);

return [
    'size' => (int) env('OC_QR_SIZE', 300),
    'margin' => (int) env('OC_QR_MARGIN', 4),
    'error_correction' => env('OC_QR_ERROR_CORRECTION', 'M'),
    'format' => env('OC_QR_FORMAT', 'png'),
];
