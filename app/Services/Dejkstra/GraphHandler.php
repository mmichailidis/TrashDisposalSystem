<?php

/**
 * Created by IntelliJ IDEA.
 * User: MidoriKage
 * Date: 05-May-18
 * Time: 11:48 PM
 */
namespace App\Services\Dejkstra;


class GraphHandler
{
    private $nodes = [];

    public function add(Node $node)
    {
        $this->nodes[$node->getName()] = $node;
    }

    public function getNode($name)
    {
        $nodes = $this->getNodes();

        return $nodes[$name];
    }

    public function getNodes()
    {
        return $this->nodes;
    }
}