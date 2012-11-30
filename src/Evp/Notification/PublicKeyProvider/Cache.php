<?php

class Evp_Notification_PublicKeyProvider_Cache implements Evp_Notification_PublicKeyProvider_Iterator_CacheInterface
{
    /**
     * @var string
     */
    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function has()
    {
        return file_exists($this->filePath);
    }

    public function get()
    {
        return include $this->filePath;
    }

    public function set($value)
    {
        $value = (string) $value;
        $contents = '<?php return \'' . strtr($value, array('\\' => '\\\\', '\'' => '\\\'')) . '\';';
        file_put_contents($this->filePath, $contents);
    }

}