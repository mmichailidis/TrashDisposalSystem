<?php

/**
 * Created by IntelliJ IDEA.
 * User: MidoriKage
 * Date: 05-May-18
 * Time: 12:47 PM
 */
namespace App\Services;

class Track
{
    private $id;
    private $size;
    private $returnWhenFull;

    public static function parse($json): Track
    {
        return new Track();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getReturnWhenFull()
    {
        return $this->returnWhenFull;
    }
}