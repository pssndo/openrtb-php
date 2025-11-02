<?php

declare(strict_types=1);

namespace OpenRTB\v3\Util;

use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\BidRequest as Request;
use OpenRTB\v3\BidResponse as Response;

/**
 * Validator - Validates OpenRTB objects
 */
class Validator
{
    /** @var list<string> */
    private array $errors = [];

    public function validateRequest(Request $request): bool
    {
        $this->errors = [];

        if (!$request->getId()) {
            $this->errors[] = 'Request ID is required';
        }

        $items = $request->getItem();
        if (empty($items)) {
            $this->errors[] = 'Request must contain at least one Item';
        } else {
            foreach ($items as $item) {
                $this->validateItem($item);
            }
        }

        return empty($this->errors);
    }

    private function validateItem(Item $item): void
    {
        if (!$item->getId()) {
            $this->errors[] = 'Item ID is required';
        }
        if (!$item->getSpec()) {
            $this->errors[] = 'Item Spec is required';
        } else {
            $this->validateSpec($item->getSpec());
        }
    }

    private function validateSpec(Spec $spec): void
    {
        if (!$spec->getPlacement()) {
            $this->errors[] = 'Spec Placement is required';
        }
    }

    public function validateResponse(Response $response): bool
    {
        $this->errors = [];

        if (!$response->getId()) {
            $this->errors[] = 'Response ID is required';
        }

        return empty($this->errors);
    }

    /** @return list<string> */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
