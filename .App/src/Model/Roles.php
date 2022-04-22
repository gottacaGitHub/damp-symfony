<?php

namespace App\Model;

class Roles
{
    public const DEFAULT_ROLE = 'ROLE_MANAGER';
    public const SUPER_ADMIN_ROLE = 'ROLE_SUPER_ADMIN';
    public const ADMIN_ROLE = 'ROLE_ADMIN';

    private static array $instances = [];

    private string $value;

    private function __construct(string $value)
    {
        if (!array_key_exists($value, self::choices())) {
            throw new \DomainException(sprintf('The value "%s" is not a valid roles.', $value));
        }

        $this->value = $value;
    }

    public static function byValue(string $value): Roles
    {

        if (!isset(self::$instances[$value])) {
            self::$instances[$value] = new static($value);
        }

        return self::$instances[$value];
    }

    public function  getValue(): string
    {
        return $this->value;
    }

    public static function choices(): array
    {
        return [
            self::DEFAULT_ROLE=> 'Менеджер',
            self::ADMIN_ROLE => 'Администратор',
            self::SUPER_ADMIN_ROLE => 'Администратор Сонаты'
        ];
    }

    public function __toString(): string
    {
        return self::choices()[$this->value];
    }
}