<?php namespace Workly\Domain;

use Illuminate\Events\Dispatcher;
use Workly\Domain\Contracts\Dispatcher as DispatcherInterface;

class LaravelDispatcher implements DispatcherInterface
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @var Log
     */
    private $log;

    public function __construct(Dispatcher $dispatcher, Log $log)
    {
        $this->event = $dispatcher;
        $this->log = $log;
    }

    /**
     * Dispatches all events
     *
     * @param array $events
     */
    public function dispatch(array $events)
    {
        foreach ($events as $event) {
            $eventName = $this->eventCommandTranslator($event);

            $this->dispatcher->fire($eventName, $event);

            $this->log->info("Event $eventName was fired");
        }
    }

    /**
     * Translates event command name to event name
     *
     * @param $event
     * @return mixed
     */
    private function eventCommandTranslator($event)
    {
        return str_replace('\\', '.', get_class($event));
    }
} 