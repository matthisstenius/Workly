<?php namespace Workly\Domain\Contracts;

interface Dispatcher
{
    public function dispatch(array $events);
} 