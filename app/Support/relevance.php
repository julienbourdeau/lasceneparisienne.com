<?php

/*
|--------------------------------------------------------------------------
| 5 Star Rating
|--------------------------------------------------------------------------
|
| Lower bound of Wilson score confidence interval for a Bernoulli parameter (0.9604)
|
| See:
|  * http://www.evanmiller.org/how-not-to-sort-by-average-rating.html
|  * https://gist.github.com/richardkundl/2950196
|  * https://onextrapixel.com/how-to-build-a-5-star-rating-system-with-wilson-interval-in-mysql/
|
*/


function score($positive, $negative) {
    if (($positive + $negative) == 0) {
        $positive++;
    }

    return ((($positive + 1.9208) / ($positive + $negative) - 1.96 * sqrt((($positive * $negative) / ($positive + $negative)) + 0.9604) / ($positive + $negative)) / (1 + 3.8416 / ($positive + $negative)));
}

function fiveStarRating($one, $two, $three, $four, $five) {
    $positive = $two * 0.25 + $three * 0.5 + $four * 0.75 + $five;
    $negative = $one + $two * 0.75 + $three * 0.5 + $four * 0.25;

    return score($positive, $negative);
}

function fiveStarRatingAverage($avg, $total)
{
    $positive = ($avg * $total - $total) / 4;
    $negative = $total - $positive;

    return score($positive, $negative);
}

function attendanceScore($declined, $noReply, $maybe, $attending)
{
    return fiveStarRating($declined, $noReply, $maybe, $attending, 0);
}

function eventPopularity($declined, $noReply, $maybe, $attending)
{
    if( $declined == 0 && $noReply == 0 && $maybe == 0 && $attending == 0) {
        return 0;
    }

    $score = attendanceScore($declined, $noReply, $maybe, $attending);

    return (int) (round($score, 2) * 100);
}
