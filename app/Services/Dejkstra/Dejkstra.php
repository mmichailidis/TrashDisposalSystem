<?php
/**
 * Created by IntelliJ IDEA.
 * User: MidoriKage
 * Date: 05-May-18
 * Time: 11:59 PM
 */

namespace App\Services\Dejkstra;


class Dejkstra
{
    protected $startingVertex;
    protected $endingNode;
    protected $graph;
    protected $paths = array();
    protected $solution = false;

    public function __construct(GraphHandler $graph)
    {
        $this->graph = $graph;
    }

    public function getDistance()
    {
        return $this->getEndingNode()->getPotential();
    }

    public function getEndingNode()
    {
        return $this->endingNode;
    }

    public function getLiteralShortestPath()
    {
        $path = $this->solve();
        $literal = '';
        foreach ($path as $p) {
            $literal .= "{$p->getName()} - ";
        }
        return substr($literal, 0, count($literal) - 4);
    }

    public function getShortestPath()
    {
        $path   = array();
        $node = $this->getEndingNode();
        $this->getEndingNode()->getChild()->setVisitedTrue();
        while ($node->getName() != $this->getStartingNode()->getName()) {
            $path[] = $node;
            $node = $node->getPotentialFrom();
        }
        $path[] = $this->getStartingNode();
        return array_reverse($path);
    }

    public function getStartingNode()
    {
        return $this->startingVertex;
    }

    public function setEndingNode(Node $vertex)
    {
        $this->endingNode = $vertex;
    }

    public function setStartingVertex(Node $vertex)
    {
        $this->paths[] = array($vertex);
        $this->startingVertex = $vertex;
    }

    public function solve()
    {
        $this->calculatePotentials($this->getStartingNode());
        $this->solution = $this->getShortestPath();
        return $this->solution;
    }

    protected function calculatePotentials(Node $node)
    {
        $connections = $node->getConnections();
        $sorted = array_flip($connections);
        krsort($sorted);
        foreach ($connections as $id => $distance) {
            $v = $this->getGraph()->getNode($id);
            $v->setPotential($node->getPotential() + $distance, $node);
            foreach ($this->getPaths() as $path) {
                $count = count($path);
                if ($path[$count - 1]->getName() === $node->getName()) {
                    $this->paths[] = array_merge($path, array($v));
                }
            }
        }
        $node->markVisited();

        foreach ($sorted as $id) {
            $node = $this->getGraph()->getNode($id);
            if (!$node->isVisited()) {
                $this->calculatePotentials($node);
            }
        }
    }

    protected function getGraph()
    {
        return $this->graph;
    }

    protected function getPaths()
    {
        return $this->paths;
    }

    protected function isSolved()
    {
        return (bool) $this->solution;
    }
}