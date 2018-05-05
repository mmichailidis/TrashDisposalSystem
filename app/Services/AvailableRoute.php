<?php

/**
 * Created by IntelliJ IDEA.
 * User: MidoriKage
 * Date: 05-May-18
 * Time: 1:45 PM
 */
namespace App\Services;


class AvailableRoute
{
    private $root;
    private $target;
    private $distance;
    private $text;

    /**
     * AvailableRoute constructor.
     */
    private function __construct()
    {
    }

    public static function parse($value): AvailableRoute
    {
        return new AvailableRoute();
    }

    /**
     * @return mixed
     */
    public function getRoot(): string
    {
        return $this->root;
    }

    /**
     * @return mixed
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @return mixed
     */
    public function getDistance(): int
    {
        return $this->distance;
    }

    /**
     * @return mixed
     */
    public function getText(): string
    {
        return $this->text;
    }
}