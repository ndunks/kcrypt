KCrypt
===================
ASCII String compression with mapped dictionary.
Example Usage
-------------
Setup dictionary:

    $dictionary	= array( 'https://','http://', 'www.google.com', 'www.', '.com' );
    KCrypt::initialize( $dictionary );
    $encrypted	= KCrypt::encrypt($original);

For more detail view on test.php

**Example Output:**

    php test.php https://www.google.com/
    
    Original length 23:
    https://www.google.com/
    
    Encrypted length 3:
    ü/
    
    Decrypted length 23:
    https://www.google.com/
    
    Compressed Ratio: **86.96%**
