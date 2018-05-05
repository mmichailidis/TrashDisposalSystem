<?php

/**
 * Created by IntelliJ IDEA.
 * User: MidoriKage
 * Date: 05-May-18
 * Time: 12:48 PM
 */

namespace App\Services;

class AlgorithmBuilder extends AbstractAlgorithmBuilder
{
    private $algorithm;
    private $tracks = array();
    private $villages = array();

    public function __construct()
    {
        $this->algorithm = new Algorithm();
    }

    public function addTrack(Track $track)
    {
        array_push($this->tracks, $track);
    }

    public function addVillage(VillageSchematics $village)
    {
        array_push($this->villages, $village);
    }

    public function getAlgorithm(): Algorithm
    {
        foreach ($this->villages as $village) {
            $village->setRoutes($this->villages);
        }

        $this->algorithm->addTracks($this->tracks);
        $this->algorithm->addVillages($this->villages);

        return $this->algorithm;
    }
}