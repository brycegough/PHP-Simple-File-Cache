<?php

class FileCache {

    public $path;
    public $data = [];
    public $expiry = 7200; // 2 hours

    public function __construct( $path = '.cache' ) {
        $this->path = $path . '.php';

        $this->load();
    }

    public function get($name, $set) {
        $value = $this->data[$name] ?? null;

        if ($value === null && is_callable($set)) {
            $this->data[$name] = $set();
            $this->save();

            return $this->data[$name];
        }

        return $value;
    }

    public function save() {
        $obj_str = serialize( $this->data );

        file_put_contents($this->path, '<?php /* ' . $obj_str . ' */ ?>');
    }

    public function load() {
        if (!file_exists($this->path)) return false;

        $modtime =  filemtime($this->path);

        if (is_numeric($modtime) && time() - $modtime >= $this->expiry) {
            unlink($this->path);
            return false;
        }

        $data = file_get_contents($this->path);
        $data = ltrim($data, '<?php /* ');
        $data = rtrim($data, ' */ ?>');

        $this->data = unserialize($data);

        return true;
    }

}
