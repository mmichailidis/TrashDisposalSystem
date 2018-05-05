<?php

/**
 * Created by IntelliJ IDEA.
 * User: MidoriKage
 * Date: 05-May-18
 * Time: 12:47 PM
 */

namespace App\Services;

use App\Village;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
        $this->availableRoutes = array();
    }

    /**
     * TODO add routes
     * @param $json
     * @return VillageSchematics
     */
    public static function parse($json): VillageSchematics
    {
        $vS = new VillageSchematics();

        $vS->name = $json['name'];
        $vS->bin = $json['bin'];
        $vS->size = $json['capacity'];
        $vS->onlyOnce = $json['OTO'];

        $village = Village::where(["name" => $vS->name])->first();

        $vS->lat = $village->latitude;
        $vS->lon = $village->longitude;
        $vS->type = TownType::getType($village->type);

        $con = DB::select(DB::raw('SELECT vill.name as destination, vill.latitude as lat, vill.longitude as lon FROM TrashDisposalSystem.connections as conn
            INNER JOIN TrashDisposalSystem.villages as vill ON vill.id = conn.connected_village
            where conn.route_village = 1;
            '));

        foreach ($con as $destinationObj) {
            array_push($vS->availableRoutes, $destinationObj->destination . ':' . $destinationObj->lat . ':' . $destinationObj->lon);
        }

        return $vS;
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
        return collect($this->availableRoutes)->filter(function (string $route) use ($visitedCollection) {
            return !$visitedCollection->contains(function (VillageSchematics $village) use ($route) {
                return $village->getName() === $route;
            });//check if collection is empty
        })->min(function (string $item) {
            dd($item);
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