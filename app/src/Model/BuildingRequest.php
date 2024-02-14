<?php
namespace App\Model;

class BuildingRequest
{
    #[Assert\NotBlank]
    public string $title;
    #[Assert\NotBlank]
    public string $address;
    #[Assert\NotBlank]
    public float $latitude;
    #[Assert\NotBlank]
    public float $longitude;
    #[Assert\NotBlank]
    public int $floors;
    #[Assert\NotBlank]
    public int $year;

    public function __construct(string $title, string $address, float $latitude, float $longitude, int $floors, int $year)
    {
        $this->title = $title;
        $this->address = $address;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->floors = $floors;
        $this->year = $year;
    }
}