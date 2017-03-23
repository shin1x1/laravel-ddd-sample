<?php
namespace Acme\Shop\Domain\Models;

abstract class Identifier implements \JsonSerializable
{
    /** @var int */
    protected $value;

    /**
     * @param int $value
     */
    private function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * @param Identifier $id
     * @return bool
     */
    public function equals(self $id): bool
    {
        return $this->value === $id->value;
    }

    /**
     * @param int $value
     * @return static
     */
    public static function of(int $value)
    {
        return new static($value);
    }

    /**
     *
     */
    public function jsonSerialize()
    {
        return $this->value;
    }
}
