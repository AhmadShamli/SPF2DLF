# SPF2DLF
A simple PHP function to display data from a log file. (Simple PHP Function To Display Log File)

## Usage

```php
require 'showlog.php';

// Display the last 150 lines of an error log
echo util_show_log('/var/www/clients/client2/web8/log/error.log', 150);
```

## Features
- Pure-PHP implementation (no shell/`tail` dependency)
- Output is HTML-escaped to prevent XSS
- Graceful handling of missing/unreadable files
- Configurable file path and line count

## Requirements
- PHP 7.4 or newer (tested up to the latest PHP 8.x)
- Uses scalar type hints, return types, and `declare(strict_types=1)`
 