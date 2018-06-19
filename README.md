### Example
```php
<?php

declare(strict_types=1);

use Frago9876543210\PNG\Color;

require_once "vendor/autoload.php";

$png = new \Frago9876543210\PNG\PNG(2, 2);

$png->setPixel(0, 0, new Color(0xff, 0, 0));
$png->setPixel(1, 0, new Color(0xff, 0, 0));

$png->setPixel(0, 1, new Color(0xff, 0xff, 0));
$png->setPixel(1, 1, new Color(0xff, 0xff, 0));

$png->buildImage();
$png->save("test.png");
```