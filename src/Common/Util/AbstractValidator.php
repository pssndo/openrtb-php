<?php

declare(strict_types=1);

namespace OpenRTB\Common\Util;

/**
 * Abstract base class for validators.
 * Provides common validation functionality for OpenRTB objects.
 */
abstract class AbstractValidator
{
    /** @var list<string> */
    protected array $errors = [];

    /**
     * Adds an error message.
     */
    protected function addError(string $message): void
    {
        $this->errors[] = $message;
    }

    /**
     * Checks if validation passed (no errors).
     */
    protected function isValid(): bool
    {
        return empty($this->errors);
    }

    /**
     * Resets error state.
     */
    protected function reset(): void
    {
        $this->errors = [];
    }

    /**
     * Returns all validation errors.
     *
     * @return list<string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Returns the first error or null if no errors.
     */
    public function getFirstError(): ?string
    {
        return $this->errors[0] ?? null;
    }

    /**
     * Checks if there are any errors.
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}