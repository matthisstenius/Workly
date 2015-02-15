<?php namespace Workly\Domain\Model\Recommendation\Types;

class Positive implements RecommendationType
{
    /**
     * Get recommendation type
     *
     * @return string
     */
    public function name()
    {
        return 'positive';
    }
}