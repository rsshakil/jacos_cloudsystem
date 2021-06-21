<?php
return [
    // user profile image save path
    'USER_UPLOAD_IMAGES_PATH' => '/public/backend/images/users/',
    'USER_UPLOAD_IMAGES_PUBLIC_PATH' => '/public/storage/backend/images/users/',

    // Tools
    'TASKCTRL' => 'tools/taskctrl/taskctrlWrapper.sh',

    // Order files
    'ORDER_DATA_PATH' => 'DATA/ORDER/order_insert_csv/',
    'ORDER_FAX_PDF_SAVE_PATH' => 'app/DATA/ORDER/order_fax_pdf/',

    // Shipment files
    'SHIPMENT_SEND_CSV_PATH' => '/DATA/SHIPMENT/shipment_send_csv',
    'SHIPMENT_MOVED_CSV_PATH' => '/DATA/SHIPMENT/shipment_send_csv/moved/',
    'SHIPMENT_DOWNLOAD_CSV_PATH' => '/DATA/SHIPMENT/shipment_download_csv',
    'JCA_FILE_PATH' => 'app/DATA/SHIPMENT/jca_files/',
    'SHIPMENT_CSV_UPDATE_PATH' => '/DATA/SHIPMENT/shipment_updated_csv',
    'SHIPMENT_PDF_SAVE_PATH' => 'app/DATA/SHIPMENT/shipment_pdf/',

    // Receive files
    'RECEIVE_DATA_PATH' => 'DATA/RECEIVE/receive_insert_csv/',
    'RECEIVE_DOWNLOAD_CSV_PATH' => '/DATA/RECEIVE/receive_download_csv',

    // Return files
    'RETURN_DATA_PATH' => '/DATA/RETURN/return_insert_csv/',
    'RETURN_DOWNLOAD_CSV_PATH' => '/DATA/RETURN/return_download_csv',

    // Invoice files
    'INVOICE_SEND_CSV_PATH' => '/DATA/INVOICE/invoice_send_csv',
    'INVOICE_MOVED_CSV_PATH' => '/DATA/INVOICE/invoice_send_csv/moved/',
    'INVOICE_DOWNLOAD_CSV_PATH' => '/DATA/INVOICE/invoice_download_csv',
    'INVOICE_COMPARE_CSV_PATH' => '/DATA/INVOICE/invoice_compare_csv',

    // Payment files
    'PAYMENT_DATA_PATH' => 'DATA/PAYMENT/payment_insert_csv/',
    'PAYMENT_DOWNLOAD_CSV_PATH' => '/DATA/PAYMENT/payment_downloaded_csv',
    'PAYMENT_UNPAID_CSV_PATH' => '/DATA/PAYMENT/payment_unpaid_csv',

    // Demo files
    'BLANK_PDF_PATH' => 'app/DEMO/PDF/ORDER/blank.pdf',

    // Pdf font
    'MIGMIX_FONT_PATH' => 'app/fonts/migmix-2p-regular.ttf',

    // 'PDF_SEND_MAIL' => 'mayeennbd@gmail.com',
    // 'PDF_SEND_MAIL' => 'fax849653@ecofax.jp',
    'PDF_SEND_MAIL' => 'sakaki@jacos.co.jp',
    'INVOICE_SCHEDULE_TIME' => '12:00',

    'adm_role_name' =>'Super Admin',
    'buyer_role_name' =>'Byr',
    'seller_role_name' =>'Slr',
    'SUCCESS' =>1,
    'ERROR' =>0,
    'JCS_EXCEPTION'=>1,
    'SEND_EXCEPTION'=>0,
    'EXCEPTION_SEND_MAILS'=>['mayeennbd@gmail.com','jacossakil@gmail.com','sakaki@jacos.co.jp'],

    'CSV_FILE_ENCODE'=>'sjis-win',

//  Byr Menu variables
    // Slr shipment files
    'SLR_SHIPMENT_DOWNLOAD_CSV_PATH' => '/BYR/DATA/SHIPMENT/slr_shipment_download_csv',
    'SLR_JCA_FILE_PATH' => 'app/BYR/DATA/SHIPMENT/jca_files/',
    'SLR_SHIPMENT_PDF_SAVE_PATH' => 'app/BYR/DATA/SHIPMENT/slr_shipment_pdf/',

];
