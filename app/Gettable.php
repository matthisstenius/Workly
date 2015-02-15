<?php namespace Workly;

trait Gettable
{
    /**
     * Get private properties
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }
    }
} 