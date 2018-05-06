<?php
/**
 * Created by IntelliJ IDEA.
 * User: MidoriKage
 * Date: 05-May-18
 * Time: 11:48 PM
 */

namespace App\Services\Dejkstra;


use App\Services\VillageSchematics;

class Node
{
    private $name;
    private $connections = [];
    private $visited = false;
    private $potential;
    private $potentialFrom;
    private $villageSchematic;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function connect(Node $node, int $weight)
    {
        $this->connections[$node->getName()] = $weight;
    }

    public function getConnections()
    {
        return $this->connections;
    }

    public function getName()
    {
        return $this->name;
    }

    public function isVisited()
    {
        return $this->visited;
    }

    public function addChild(VillageSchematics $vS)
    {
        $this->villageSchematic = $vS;
    }

    public function markVisited()
    {
        $this->visited = true;
    }

    public function getPotential()
    {
        return $this->potential;
    }

    public function getChild()
    {
        return $this->villageSchematic;
    }

    public function getPotentialFrom()
    {
        $this->potentialFrom->getChild()->setVisitedTrue();
        return $this->potentialFrom;
    }

    public function setPotential($potential, Node $from)
    {
        $potential = (int)$potential;
        if (!$this->getPotential() || $potential < $this->getPotential()) {
            $this->potential = $potential;
            $this->potentialFrom = $from;
            return true;
        }
        return false;
    }
}