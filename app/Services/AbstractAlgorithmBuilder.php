<?php

/**
 * Created by IntelliJ IDEA.
 * User: MidoriKage
 * Date: 05-May-18
 * Time: 12:47 PM
 */
namespace App\Services;

abstract class AbstractAlgorithmBuilder
{
    abstract function getAlgorithm(): Algorithm;
    abstract function addTrack(Track $track);
    abstract function addVillage(VillageSchematics $village);
    abstract function lastNodeOneTimeOnlyStatus(bool $flag);
}