<?php

/**
 * Created by IntelliJ IDEA.
 * User: MidoriKage
 * Date: 05-May-18
 * Time: 12:46 PM
 */

namespace App\Services;

class Algorithm
{
    private $villages = array();
    private $tracks = array();

    function addVillages(array $village)
    {
        $this->villages = $village;
    }

    function addTracks(array $track)
    {
        $this->tracks = $track;
    }

    function execute($data)
    {
        $start = null;
        $end = null;

        foreach ($this->villages as $village) {
            if ($village->getType() == "start") {
                $start = $village;
            } else if ($village->getType() == "end") {
                $end = $village;
            }
        }

        $previousNode = null;
        $currentNode = $start;
        $flag = true;

        while ($flag) {
            $route = $currentNode->getShortestPath(collect($this->villages)->filter(function($village) {
                return $village->isVisited();
            }));

            if ($route === null) {
                $currentNode = $previousNode;
                continue;
            }

            $currentNode->setVisistedTrue();
            $villageName = $route->getTarget();
            $newNode = $this->locateVillage($villageName);

            if ($newNode == null) {
                throw new \InvalidArgumentException();
            }

            $flag = $this->keepGoing();
            $previousNode = $currentNode;
            $currentNode = $newNode;
            //doesnt end at the end.. needs to locate the end also
        }

        dd($this->villages);
        return 'a';
    }

    private function keepGoing(): bool
    {
        foreach ($this->villages as $village) {
            if (!$village->isVisited) {
                return true;
            }
        }
        return false;
    }

    private function locateVillage(string $name): VillageSchematics
    {
        foreach ($this->villages as $village) {
            if ($village->getName() === $name) {
                return $village;
            }
        }
        return null;
    }
}