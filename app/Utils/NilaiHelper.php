<?php

namespace App\Utils;

class NilaiHelper
{
    public ?float $cognitive = null;
    public ?float $motivation = null;
    public ?float $adaptability = null;
    public ?float $creativity = null;
    public ?float $eq = null;
    public ?float $interpersonal = null;
    public ?float $technical = null;
    public ?float $scholastic = null;
    public ?int $exp = null;

    public function __construct() {}

    public function toArray()
    {
        return [
            'cognitive' => $this->cognitive,
            'motivation' => $this->motivation,
            'adaptability' => $this->adaptability,
            'creativity' => $this->creativity,
            'eq' => $this->eq,
            'interpersonal' => $this->interpersonal,
            'technical' => $this->technical,
            'scholastic' => $this->scholastic,
            'exp' => $this->exp,
        ];
    }
}
