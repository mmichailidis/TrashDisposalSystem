<?php

/**
 * Created by IntelliJ IDEA.
 * User: MidoriKage
 * Date: 05-May-18
 * Time: 12:47 PM
 */

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class VillageSchematics
{
    private $name;
    private $lon;
    private $lat;
    private $bin;
    private $size;
    private $onlyOnce;
    private $availableRoutes;
    private $isVisited;
    private $type;

    private function __construct()
    {
        $this->isVisited = false;
    }

    public static function parse($json): VillageSchematics
    {
        //convert type to string here before return
        return new VillageSchematics();
    }

    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getLon(): float
    {
        return $this->lon;
    }

    /**
     * @return mixed
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @return mixed
     */
    public function getBin(): bool
    {
        return $this->bin;
    }

    /**
     * @return mixed
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getOnlyOnce(): bool
    {
        return $this->onlyOnce;
    }

    /**
     * @return mixed
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isVisited(): bool
    {
        return $this->isVisited;
    }

    public function setVisitedTrue()
    {
        $this->isVisited = true;
    }

    public function getShortestPath(Collection $visitedCollection): AvailableRoute
    {
        return collect($this->availableRoutes)->filter(function (AvailableRoute $route) use ($visitedCollection) {
            return !$visitedCollection->contains(function (VillageSchematics $village) use ($visitedCollection, $route) {
                return $village->getName() === $route->getTarget();
            });//check if collection is empty
        })->min(function (AvailableRoute $item) {
            return $item->getDistance();
        });
    }

    public function getUnvisitedPaths(Collection $visitedCollection): array
    {
        return collect($this->availableRoutes)->filter(function (AvailableRoute $route) use ($visitedCollection) {
            return !$visitedCollection->contains(function (VillageSchematics $village) use ($visitedCollection, $route) {
                return $village->getName() === $route->getTarget();
            });
        });
    }
}