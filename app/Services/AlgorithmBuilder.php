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

    public function lastNodeOneTimeOnlyStatus(bool $flag){
        $this->lastNodeOneTimeStatus = $flag;
    }

    public function specificAreasOnly(boolean $flag){
        $this->specificAreasOnly = $flag;
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

        return $this->algorithm;
    }
}