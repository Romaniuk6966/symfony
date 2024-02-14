<?php
namespace App\Attribute;

use Attribute;
use Composer\Semver\Constraint\Constraint;

#[Attribute(Attribute::TARGET_PARAMETER)]
class RequestFile
{
    /**
     * @var string $field
     */
    private string $field;

    /**
     * @var Constraint[] $constraints
     */
    private array $constraints;

    public function __construct(string $field, array $constraints = [])
    {
        $this->field = $field;
        $this->constraints = $constraints;
    }

    /**
     * @return string $field
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return Constraint[]
     */
    public function getConstraints(): array
    {
        return $this->constraints;
    }
}
