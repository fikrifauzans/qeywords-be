<?php

namespace App\Handler\Files;

class Base64ObjectHandler
{
    public const PARAM_NAME = 'name';
    public const PARAM_TYPE = 'type';
    public const PARAM_SIZE = 'size';
    public const PARAM_BASE64 = 'base64';

    private array $base64Object;
    private string $storagePath;
    private string $name;
    private string $size;
    private string $path;

    private  $file;

    public function __construct(array $base64Object, string $storagePath)
    {
        $this->base64Object = $base64Object;
        $this->storagePath = $storagePath;
    }


    public function setObjectValueBase64()
    {
        $this->name = $this->base64Object[SELF::PARAM_NAME];
        $this->size = $this->base64Object[SELF::PARAM_SIZE];
        $this->path = $this->storagePath . '/' . $this->base64Object[SELF::PARAM_NAME];
        return $this;
    }


    public function decodeBse64DataToFile()
    {
        $path =   public_path($this->storagePath . '/' . $this->name);
        $exp = explode(',', $this->base64Object[SELF::PARAM_BASE64]);
        $base64 = array_pop($exp);
        $data = base64_decode($base64);
        file_put_contents($path, $data);
    }

    public function  storeAndGetObject()
    {
        $this->decodeBse64DataToFile();
        return json_encode([
            'name' => $this->name,
            'size' => $this->size,
            'path' => $this->path,
        ], JSON_FORCE_OBJECT);
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the value of size
     *
     * @return  self
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get the value of path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the value of path
     *
     * @return  self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }
}
