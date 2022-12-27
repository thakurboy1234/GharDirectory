<?php

namespace Botble\Analytics\GA4\Traits;

use Google\Analytics\Data\V1beta\Metric;

trait MetricTrait
{
    public array $metrics = [];

    public function metric(string $name): self
    {
        $this->metrics[] = (new Metric())
            ->setName($name);

        return $this;
    }

    public function metrics(string ...$items): self
    {
        foreach ($items as $item) {
            $this->metric($item);
        }

        return $this;
    }
}
