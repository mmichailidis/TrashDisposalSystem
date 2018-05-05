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

    public function __construct()
    {
        $this->algorithm = new Algorithm();
    }

    public function addTrack(Track $track)
    {
        $this->algorithm->addTrack($track);
    }

    public function addVillage(VillageSchematics $village)
    {
        $this->algorithm->addVillage($village);
    }

    public function getAlgorithm(): Algorithm
    {
        return $this->algorithm;
    }
}