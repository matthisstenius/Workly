<?php namespace Workly\Domain\Model\Recommendation\Types;

interface RecommendationType
{
    /**
     * Get recommendation type
     *
     * @return string
     */
    public function name();
} 