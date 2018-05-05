<?php

/**
 * Created by IntelliJ IDEA.
 * User: MidoriKage
 * Date: 05-May-18
 * Time: 1:45 PM
 */

namespace App\Services;


class AvailableRoute
{
    private $root;
    private $target;
    private $distance;
    private $text;

    /**
     * AvailableRoute constructor.
     */
    private function __construct()
    {
    }

    public static function parse($value): AvailableRoute
    {
        return new AvailableRoute();
    }

    public static function generate(VillageSchematics $root, VillageSchematics $target): AvailableRoute
    {
        $aR = new AvailableRoute();
        $aR->root = $root;
        $aR->target = $target;

        $calc = new DistanceCalculator();
        $results = $calc->calculateDistance($aR->getRoot()->getLat(), $aR->getRoot()->getLon(),
            $aR->getTarget()->getLat(), $aR->getTarget()->getLon());
        $aR->distance = $results['meters_distance'];
        $aR->text = $results['km_distance'];
        return $aR;
    }

    /**
     * @return mixed
     */
    public function getRoot(): VillageSchematics
    {
        return $this->root;
    }

    /**
     * @return mixed
     */
    public function getTarget(): VillageSchematics
    {
        return $this->target;
    }

    /**
     * @return mixed
     */
    public function getDistance(): int
    {
        return $this->distance;
    }

    /**
     * @return mixed
     */
    public function getText(): string
    {
        return $this->text;
    }
}