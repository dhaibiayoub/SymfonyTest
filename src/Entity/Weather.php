<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\WeatherRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeatherRepository::class)]
class Weather
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $city;

    #[ORM\Column]
    private \DateTimeImmutable $cityLocalTime;

    #[ORM\Column]
    private float $temperature = 0.;

    #[ORM\Column]
    private float $feelslike = 0.;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $icon = null;

    #[ORM\Column]
    private float $windSpeed = 0.;

    #[ORM\Column]
    private int $humidity;

    #[ORM\Column]
    private float $uv = 0.;

    #[ORM\Column]
    private \DateTimeImmutable $requestedAt;

    public function __construct()
    {
        $this->requestedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCityLocalTime(): \DateTimeImmutable
    {
        return $this->cityLocalTime;
    }

    public function setCityLocalTime(\DateTimeImmutable $cityLocalTime): static
    {
        $this->cityLocalTime = $cityLocalTime;

        return $this;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getFeelslike(): float
    {
        return $this->feelslike;
    }

    public function setFeelslike(float $feelslike): static
    {
        $this->feelslike = $feelslike;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getWindSpeed(): float
    {
        return $this->windSpeed;
    }

    public function setWindSpeed(float $windSpeed): static
    {
        $this->windSpeed = $windSpeed;

        return $this;
    }

    public function getHumidity(): int
    {
        return $this->humidity;
    }

    public function setHumidity(int $humidity): static
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getUv(): float
    {
        return $this->uv;
    }

    public function setUv(float $uv): static
    {
        $this->uv = $uv;

        return $this;
    }

    public function getRequestedAt(): \DateTimeImmutable
    {
        return $this->requestedAt;
    }

    public function setRequestedAt(\DateTimeImmutable $requestedAt): static
    {
        $this->requestedAt = $requestedAt;

        return $this;
    }
}
