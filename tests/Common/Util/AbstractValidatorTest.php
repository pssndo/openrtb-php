<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common\Util;

use OpenRTB\Common\Util\AbstractValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\Util\AbstractValidator
 */
class AbstractValidatorTest extends TestCase
{
    public function testAddError(): void
    {
        $validator = new class extends AbstractValidator {
            public function validate(mixed $data): bool
            {
                if (empty($data)) {
                    $this->addError('Data is empty');
                }
                return $this->isValid();
            }
        };

        $result = $validator->validate('');

        $this->assertFalse($result);
        $this->assertTrue($validator->hasErrors());
        $this->assertCount(1, $validator->getErrors());
    }

    public function testIsValid(): void
    {
        $validator = new class extends AbstractValidator {
            public function validate(mixed $data): bool
            {
                // No errors added, should be valid
                return $this->isValid();
            }
        };

        $result = $validator->validate('valid-data');

        $this->assertTrue($result);
        $this->assertFalse($validator->hasErrors());
    }

    public function testReset(): void
    {
        $validator = new class extends AbstractValidator {
            public function validate(mixed $data): bool
            {
                $this->reset(); // Reset errors before validation

                if (empty($data)) {
                    $this->addError('Data is empty');
                }
                return $this->isValid();
            }
        };

        // First validation with error
        $validator->validate('');
        $this->assertTrue($validator->hasErrors());
        $this->assertCount(1, $validator->getErrors());

        // Second validation should reset errors
        $validator->validate('valid-data');
        $this->assertFalse($validator->hasErrors());
        $this->assertCount(0, $validator->getErrors());
    }

    public function testGetErrors(): void
    {
        $validator = new class extends AbstractValidator {
            public function validateMultiple(): void
            {
                $this->addError('Error 1');
                $this->addError('Error 2');
                $this->addError('Error 3');
            }
        };

        $validator->validateMultiple();
        $errors = $validator->getErrors();

        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($errors);
        $this->assertCount(3, $errors);
        $this->assertEquals('Error 1', $errors[0]);
        $this->assertEquals('Error 2', $errors[1]);
        $this->assertEquals('Error 3', $errors[2]);
    }

    public function testGetFirstError(): void
    {
        $validator = new class extends AbstractValidator {
            public function validateMultiple(): void
            {
                $this->addError('First error');
                $this->addError('Second error');
            }
        };

        $validator->validateMultiple();
        $firstError = $validator->getFirstError();

        $this->assertEquals('First error', $firstError);
    }

    public function testGetFirstErrorReturnsNullWhenNoErrors(): void
    {
        $validator = new class extends AbstractValidator {
            public function validate(): bool
            {
                return $this->isValid();
            }
        };

        $validator->validate();
        $firstError = $validator->getFirstError();

        $this->assertNull($firstError);
    }

    public function testHasErrors(): void
    {
        $validator = new class extends AbstractValidator {
            public function validateWithError(): void
            {
                $this->addError('Test error');
            }
        };

        $this->assertFalse($validator->hasErrors());

        $validator->validateWithError();

        $this->assertTrue($validator->hasErrors());
    }

    public function testGetErrorsReturnsEmptyArrayInitially(): void
    {
        $validator = new class extends AbstractValidator {
        };

        $errors = $validator->getErrors();

        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($errors);
        $this->assertEmpty($errors);
    }

    public function testMultipleValidationCycles(): void
    {
        $validator = new class extends AbstractValidator {
            public function validate(string $value): bool
            {
                $this->reset();

                if (strlen($value) < 3) {
                    $this->addError('Value too short');
                }

                if (!preg_match('/^[a-z]+$/', $value)) {
                    $this->addError('Value must contain only lowercase letters');
                }

                return $this->isValid();
            }
        };

        // First validation - should fail both rules
        $result1 = $validator->validate('A1');
        $this->assertFalse($result1);
        $this->assertCount(2, $validator->getErrors());

        // Second validation - should pass
        $result2 = $validator->validate('abc');
        $this->assertTrue($result2);
        $this->assertCount(0, $validator->getErrors());

        // Third validation - should fail one rule
        $result3 = $validator->validate('ab');
        $this->assertFalse($result3);
        $this->assertCount(1, $validator->getErrors());
        $this->assertEquals('Value too short', $validator->getFirstError());
    }
}
