<?php
return [
    // user profile image save path
    'USER_UPLOAD_IMAGES_PATH' => '/public/backend/images/users/',
    'USER_UPLOAD_IMAGES_PUBLIC_PATH' => '/public/storage/backend/images/users/',

    // Scenarios
    // Order data
    'ORDER_DATA_PATH' => 'order/',
    'RECEIVE_DATA_PATH' => 'receives/',
    'RETURN_DATA_PATH' => 'returns/',
    'PAYMENT_DATA_PATH' => 'payments/',


    // Tools
    'TASKCTRL' => 'tools/taskctrl/taskctrlWrapper.sh',

    'SHIPMENT_CSV_PATH' => '/shipment_csv',
    'RECEIVE_CSV_PATH' => '/receive_csv',
    'RETURN_CSV_PATH' => '/return_csv',
    'PAYMENT_CSV_PATH' => '/payment_downloaded_csv',
    'PAYMENT_UNPAID_CSV_PATH' => '/payment_unpaid_csv',
    'SHIPMENT_CSV_UPDATE_PATH' => '/shipment_updated_csv',
    // Fixed length file save path
    'FIXED_LENGTH_FILE_PATH' => 'app/fixed_length_files/',
    'INDEPEN_FILE_PATH' => 'app/indepen_files/',
    'INDEPEN_CSV_PATH' => 'indepen_csv_files/',
    // Pdf
    'MIGMIX_FONT_PATH' => 'app/fonts/migmix-2p-regular.ttf',
    'BLANK_PDF_PATH' => 'app/order_pdf/demo/blank.pdf',
    'ORDER_PDF_SAVE_PATH' => 'app/order_pdf/created/',
    'SHIPMENT_PDF_SAVE_PATH' => 'app/shipment_pdf/created/',
    'PDF_SEND_MAIL' => 'mayeennbd@gmail.com',
    // 'PDF_SEND_MAIL' => 'fax849653@ecofax.jp',
    // 'PDF_SEND_MAIL' => 'sakaki@jacos.co.jp',
    'INVOICE_SCHEDULE_TIME' => '12:00',

    'INVOICE_SCHEDULE_START_TIME' => '14:00',
    'INVOICE_SCHEDULE_END_TIME' => '23:00',
    'INVOICE_CSV_PATH' => '/invoice_csv',
    'INVOICE_COMPARE_CSV_PATH' => '/invoice_compare_csv',
    'adm_role_name' =>'Super Admin',
    'buyer_role_name' =>'Byr',
    'seller_role_name' =>'Slr',
    'SUCCESS' =>1,
    'ERROR' =>0,
    'JCS_EXCEPTION'=>1,

    'CSV_FILE_ENCODE'=>'sjis-win',
//  Byr Menu variables
    'SLR_SHIPMENT_CSV_PATH' => '/BYR/slr_shipment_csv',
    'SLR_FIXED_LENGTH_FILE_PATH' => 'app/BYR/slr_fixed_length_files/',

];
