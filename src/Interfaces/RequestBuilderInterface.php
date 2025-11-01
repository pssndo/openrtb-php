<?php

declare(strict_types=1);

namespace OpenRTB\Interfaces;

interface RequestBuilderInterface
{
    public function setId(string $id): static;

    public function build(): ObjectInterface;
}