<?php

/**
 * Created by IntelliJ IDEA.
 * User: MidoriKage
 * Date: 05-May-18
 * Time: 12:46 PM
 */

namespace App\Services;

use App\Services\Dejkstra\Dejkstra;
use App\Services\Dejkstra\GraphHandler;
use App\Services\Dejkstra\Node;
use Illuminate\Support\Facades\Log;

class Algorithm
{
    private $calculator;
    private $villages = array();
    private $tracks = array();
    private $lastNodeOneTimeStatus;

    function addVillages(array $village)
    {
        $this->villages = $village;
    }

    function addTracks(array $track)
    {
        $this->tracks = $track;
    }

    function lastNodeOneTimeStatus(bool $lastNodeOneTimeStatus)
    {
        $this->lastNodeOneTimeStatus = $lastNodeOneTimeStatus;
    }

    function execute()
    {
        $this->calculator = new DistanceCalculator();

        $start = null;
        $end = null;

        foreach ($this->villages as $village) {
            if ($village->getType() == "start") {
                $start = $village;
                $start->setVisitedTrue();
            } else if ($village->getType() == "end") {
                $end = $village;
            }
        }

        $currentVillage = $start;
        $flag = false;

        $isGoingBack = false;
        $useLocator = false;
        $lookingFor = null;

        $path = [];
        $secondaryResults = [];
        do {
            if (!$useLocator) {
                $max = count($currentVillage->getAvailableRoutes());
                $val = rand(0, $max - 1);
                $villageName = $currentVillage->getAvailableRoutes()[$val];
                $vilObj = $this->locateVillage($villageName);

                Log::info("CurrentArea : " . $currentVillage->getName());
                Log::info("NextArea : " . $vilObj->getName());

                $currentVillage->setVisitedTrue();

                if ($this->lastNodeOneTimeStatus && $vilObj->getName() == $end->getName()) {
                    Log::info("Canceling as the village selected is the last");
                    $areAllNodesVisited = $this->areAllSurroundingVisited($currentVillage->getAvailableRoutes());
                    if ($areAllNodesVisited) {
                        Log::info("Activated locator");
                        $useLocator = true;
                    }
                    continue;
                }

                if ($vilObj->isVisited()) {
                    Log::info("Canceled");
                    $areAllNodesVisited = $this->areAllSurroundingVisited($currentVillage->getAvailableRoutes());

                    if ($areAllNodesVisited) {
                        $useLocator = true;
                    }
                    continue;
                }

                array_push($path, $currentVillage);
                $currentVillage = $vilObj;
            } else {
                $innerFlag = true;
                $lastName = $currentVillage->getName();
                do {
                    $result = array();
                    $locatedVillages = $this->villagesNeeded();
                    if (empty($locatedVillages)) {
                        Log::info("locatedVillages was empty");
                        if ($lastName === $end->getName()) {
                            Log::info("current was last");
                            Log::info("currentVillage name " . $currentVillage->getName());
                            Log::info("endVillage name " . $end->getName());
                            $flag = true;
                            break;
                            //done
                            //miracle
                        } else {
                            Log::info("current was NOT last");
                            $result = $this->getTargetedPath($lastName, $end->getName());
                            Log::info("currentVillage name " . $lastName);
                            Log::info("endVillage name " . $end->getName());
                            array_push($secondaryResults, $result);
                            $flag = true;
                            break;
                        }
                    }
                    Log::info("need to go from " . $lastName . " to " . $locatedVillages[0]->getName());
                    $result = $this->getTargetedPath($lastName, $locatedVillages[0]->getName());
                    $lastName = $locatedVillages[0]->getName();
                    array_push($secondaryResults, $result);
                } while ($innerFlag);
            }
        } while (!$flag);

        $distance = 0;
        $item = $this->locateVillage($path[0]->getName());
        $strPath = '{' . $path[0]->getName() . ',' . $item->getLat() . ',' . $item->getLon() . '}' . ":";
        for ($i = 1; $i < count($path); $i++) {
            $distance += $this->calculator->calculateDistance($path[$i - 1]->getLat(), $path[$i - 1]->getLon(),
                $path[$i]->getLat(), $path[$i]->getLon())["meters_distance"];
            $item = $this->locateVillage($path[$i]->getName());
            $strPath = $strPath . '{' . $path[$i]->getName() . ',' . $item->getLat() . ',' . $item->getLon() . '}' . ":";
        }
        $lastVal = "";

        foreach ($secondaryResults as $result) {
            foreach ($result as $inner) {
                if ($lastVal === $inner->getName())
                    continue;
                $item = $this->locateVillage($inner->getName());
                $strPath = $strPath . '{' . $inner->getName() . ',' . $item->getLat() . ',' . $item->getLon() . '}' . ":";
                $distance += $inner->getPotential();
                $lastVal = $inner->getName();
            }
        }

        return [
            'distance' => $distance,
            'path' => $strPath
        ];
    }

    public function getTargetedPath($from, $to, $fromPath = array(), $endFlag = false)
    {
        $vil = $this->locateVillage($to);
        $skipEnd = false;
        if ($vil->getType() !== "end") {
            $skipEnd = true;
        }

        Log::info("Starting targeted path with rules skipEnd: " . $skipEnd . " endUses: " .
            $this->lastNodeOneTimeStatus . " villageName: " . $vil->getName());

        $graph = new GraphHandler();

        $nodes = [];

        foreach ($this->villages as $village) {
            $node = new Node($village->getName());
            if ($village->getType() === "end" && $skipEnd && $this->lastNodeOneTimeStatus) {
                Log::info("Skipping ending point(1)");
                continue;
            }

            $node->addChild($village);
            $nodes[$village->getName()] = $node;
        }

        foreach ($nodes as $node) {
            $villageObj = $this->locateVillage($node->getName());
            foreach ($villageObj->getAvailableRoutes() as $route) {
                $villageTarget = $this->locateVillage($route);
                if ($villageTarget->getType() === "end" && $skipEnd && $this->lastNodeOneTimeStatus) {
                    Log::info("Skipping ending point(2)");
                    continue;
                }

                $cal = $this->calculator->calculateDistance($villageObj->getLat(), $villageObj->getLon(),
                    $villageTarget->getLat(), $villageTarget->getLon());

                $node->connect($nodes[$villageTarget->getName()], $cal['meters_distance']);
            }
        }

        foreach ($nodes as $node) {
            $graph->add($node);
        }

        $de = new Dejkstra($graph);
        $de->setStartingVertex($nodes[$from]);
        $de->setEndingNode($nodes[$to]);
        Log::info("About to solve");
        return $de->solve();
    }

    public function getTargetedPath2($from, $to, $fromPath = array(), $endFlag = false)
    {
        $unvisitedNodes = array();
        $unvisitedNodes = collect($this->villages)->flatMap(function ($item, $key) {
            return [$item->getName() => $item];
        })->toArray();
//        foreach ($this->villages as $village) {
//            $unvisitedNodes[$village->getName()] = $village;
////            array_push($unvisitedNodes, $village, $village->getName());
//        }

        $nodes = array_keys($unvisitedNodes);

        $startNode = $unvisitedNodes[$from->getName()];
        $currentNode = $startNode;
        $paths = [];

        for (; ;) {
            $myLat = $currentNode->getLat();
            $myLon = $currentNode->getLon();
            foreach ($currentNode->getAvailableRoutes() as $availableRoute) {
                $villageObj = null;
                foreach ($this->villages as $village) {
                    if ($village->getName() === $availableRoute) {
                        $villageObj = $village;
                    }
                }

                if (is_null($villageObj)) {
                    throw new \InvalidArgumentException();
                }

                $distance = $this->calculator->calculateDistance($myLat, $myLon,
                    $villageObj->getLat(), $villageObj->getLon());

                dd($distance);
            }
            dd($currentNode);
        }

        $totalMap = [];


        $distance = [];
        $parent = [];
        $visit = [];
        dd("fill");
    }

    public function areAllSurroundingVisited(array $names): bool
    {
        foreach ($names as $name) {
            $vil = $this->locateVillage($name);
            if (!$vil->isVisited() && !($this->lastNodeOneTimeStatus && $vil->getType() === "end")) {
                return false;
            }
        }
        return true;
    }

    private function villagesNeeded()
    {
        $toReturn = array();
        foreach ($this->villages as $village) {
            if (!$village->isVisited()) {
                array_push($toReturn, $village);
            }
        }
        return $toReturn;
    }

    private function wasTheRouteFulfilled(): bool
    {
        foreach ($this->villages as $village) {
            if (!$village->isVisited()) {
                return false;
            }
        }
        return true;
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