<?php

declare(strict_types=1);

namespace OpenRTB\Interfaces;

interface ResponseBuilderInterface
{
    public function setBidId(string $bidId): static;

    public function build(): ObjectInterface;
}
