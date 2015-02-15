<?php namespace Workly\Domain;

trait EventRecorder {
    /**
     * @var array
     */
    private $events;

    /**
     * Adds event to events array
     *
     * @param $event
     */
    public function raise($event)
    {
        $this->events[] = $event;
    }

    /**
     * Returns all events
     */
    public function releaseEvents()
    {
        $events = $this->events;

        $this->events = [];

        return $events;
    }
} 