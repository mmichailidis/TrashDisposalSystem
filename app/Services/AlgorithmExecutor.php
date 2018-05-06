<?php

/**
 * Created by IntelliJ IDEA.
 * User: MidoriKage
 * Date: 05-May-18
 * Time: 12:29 PM
 */

namespace App\Services;

class AlgorithmExecutor
{
    /**
     * @var AbstractAlgorithmBuilder
     */
    private $algorithmBuilder;

    public function __construct(AbstractAlgorithmBuilder $algorithmBuilder)
    {
        $this->algorithmBuilder = $algorithmBuilder;
    }

    public function addVillage(VillageSchematics $village)
    {
        $this->algorithmBuilder->addVillage($village);
    }

    public function addTrack(Track $track)
    {
        $this->algorithmBuilder->addTrack($track);
    }

    public function lastNodeOneTimeOnlyStatus(bool $flag)
    {
        $this->algorithmBuilder->lastNodeOneTimeOnlyStatus($flag);
    }

    public function specificAreasOnly(bool $flag)
    {
        $this->algorithmBuilder->specificAreasOnly($flag);
    }

    public function specificAreasOnlyAndInclusive(bool $flag)
    {
        $this->algorithmBuilder->specificAreasOnlyAndInclusive($flag);
    }

    public function execute()
    {
        $algorithm = $this->algorithmBuilder->getAlgorithm();

        return $algorithm->execute();
    }
}
