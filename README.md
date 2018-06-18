### Example
```php
<?php

declare(strict_types=1);

require_once "vendor/autoload.php";

$png = new \Frago9876543210\PNG\PNG(64, 64,
	str_repeat("\x00\x00\xff\xff", 64 * 32) . str_repeat("\xff\xff\x00\xff", 64 * 32)
);
$png->save("test.png");
```