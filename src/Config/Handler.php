<?php
namespace raczsimon\nfw\Config;

/**
 * Handles the configuration instance for the runtime
 */
class Handler
{
    const
        AS_RETURN=0,
        AS_OBJECT=1,
        AS_ARRAY=2;
    
    public $configuration;
    
    /**
     * Set the configuration file
     * @param string $file Path to configuration file
     */
    public function set($configuration)
    {
        $this->configuration = $configuration;
    }
    
    /**
     * Get the configuration file
     */
    public function get()
    {
        return $this->configuration;
    }
    
    /**
     * Parse the configuration file
     * @param int $type What should you do with the parsed file?
     * @return mixed
     */
    public function parse($type = 1)
    {
        $parsed = parse_ini_file($this->configuration);
        
        switch ($type) {
            case self::AS_RETURN:
                return $parsed;
                break;
            case self::AS_OBJECT:
                $this->configuration = (object) $parsed;
                break;
            case self::AS_ARRAY:
                $this->configuration = $parsed;
                break;
        }
        
        return 0;
    }
}