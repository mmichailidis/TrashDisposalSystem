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
    private $lastNodeOneTimeStatus = false;
    private $specificAreasOnly = false;
    private $specificAreasOnlyAndInclusive = false;
    private $twoTracks = false;

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

    public function lastNodeOneTimeOnlyStatus(bool $flag)
    {
        $this->lastNodeOneTimeStatus = $flag;
    }

    public function specificAreasOnly(bool $flag)
    {
        $this->specificAreasOnly = $flag;
    }

    public function specificAreasOnlyAndInclusive(bool $flag)
    {
        $this->specificAreasOnlyAndInclusive = $flag;
    }

    public function twoTracks(bool $flag)
    {
        $this->twoTracks = $flag;
    }

    public function getAlgorithm(): Algorithm
    {
        foreach ($this->villages as $village) {
            $village->setRoutes();
        }

        $this->algorithm->addTracks($this->tracks);
        $this->algorithm->addVillages($this->villages);
        $this->algorithm->lastNodeOneTimeStatus($this->lastNodeOneTimeStatus);
        $this->algorithm->specificAreasOnly($this->specificAreasOnly);
        $this->algorithm->specificAreasOnlyAndInclusive($this->specificAreasOnlyAndInclusive);
        $this->algorithm->twoTracks($this->twoTracks);

        return $this->algorithm;
    }
}