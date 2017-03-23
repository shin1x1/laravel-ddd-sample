<?php
namespace Acme\Shop\Domain\Models;

interface Domainable
{
    /**
     * @return mixed
     */
    public function toDomain();
}