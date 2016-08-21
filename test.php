<?php

require_once "KCrypt.php";

$ori	= @$argv[1] ?: 'https://www.google.com/login?other=arg';

$dictionary	= array( 'https://','http://', 'www.google.com', 'www.', '.com' );

KCrypt::initialize( $dictionary );

$enc	= KCrypt::encrypt($ori);
$dec	= KCrypt::decrypt($enc);

printf("Original length %d:\n%s\n\n", strlen($ori), $ori);
printf("Encrypted length %d:\n%s\n\n", strlen($enc), $enc);
printf("Decrypted length %d:\n%s\n\n", strlen($dec), $dec);

$ratio	= 100 / strlen($ori) * ( strlen($ori) - strlen($enc) );
printf("Compressed Ratio: %.2f%%", $ratio);
