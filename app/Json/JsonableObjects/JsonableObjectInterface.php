<?php


namespace App\Json\JsonableObjects;


interface JsonableObjectInterface
{
    /**
     * @return string
     */
    public function toJson();

    /**
     * @return array
     */
    public function setRules();

    /**
     * @return bool
     */
    public function validate();

    /**
     * @return array
     */
    public function getData();
}