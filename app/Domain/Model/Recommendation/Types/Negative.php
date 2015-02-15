<?php

namespace Workly\Domain\Model\Recommendation\Types;

class Negative implements RecommendationType
{
    /**
     * Get recommendation type
     *
     * @return string
     */
    public function name()
    {
        return 'negative';
    }
}
