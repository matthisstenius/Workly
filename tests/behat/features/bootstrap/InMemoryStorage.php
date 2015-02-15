<?php 
class InMemoryStorage {
    /**
     * @var array
     */
    private $data;

    /**
     * @var InMemoryStorage
     */
    private static $instance;

    private function __construct()
    {
        $this->data = [];
        self::$instance = $this;
    }

    /**
     * Get singleton
     *
     * @return InMemoryStorage
     */
    public static function make()
    {
        if (self::$instance) {
            return self::$instance;
        }
        
        return new self;
    }

    /**
     * Set data
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Get value based on key
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        if ( ! isset($this->data[$key])) {
            throw new InvalidArgumentException('Key does not exist!');
        }

        return $this->data[$key];
    }
} 