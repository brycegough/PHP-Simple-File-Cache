# PHP-Simple-File-Cache
Create a simple caching/storage system using PHP files

```PHP
/*
 * Include File Cache Class
 */
include(__DIR__ . '/FileCache.php');

/*
 * Define a location to store the cache file (excluding the file extension)
 *
 * For example, the below will use the path: /path/to/web/root/.storage.php
 */
define('STORAGE_FILE', __DIR__ . '/.storage'); 

/*
 * Create an instance of the class
 */
$storage = new FileCache( STORAGE_FILE );

/*
 * Fetch a value, with a callback to set the value
 */
$value = $storage->get('my_value', function() {
    return [
        'some' => 'data'  
    ];
});
```
