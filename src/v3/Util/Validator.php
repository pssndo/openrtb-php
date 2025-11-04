<?php

declare(strict_types=1);

namespace OpenRTB\v3\Util;

use OpenRTB\Common\Util\AbstractValidator;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\BidRequest as Request;
use OpenRTB\v3\BidResponse as Response;

/**
 * Validator - Validates OpenRTB objects
 */
class Validator extends AbstractValidator
{

    public function validateRequest(Request $request): bool
    {
        $this->reset();

        if (!$request->getId()) {
            $this->addError('Request ID is required');
        }

        $items = $request->getItem();
        if (empty($items)) {
            $this->addError('Request must contain at least one Item');
        } else {
            foreach ($items as $item) {
                // @phpstan-ignore-next-line - Defensive runtime check
                if ($item instanceof Item) {
                    $this->validateItem($item);
                }
            }
        }

        return $this->isValid();
    }

    private function validateItem(Item $item): void
    {
        if (!$item->getId()) {
            $this->addError('Item ID is required');
        }
        if (!$item->getSpec()) {
            $this->addError('Item Spec is required');
        } else {
            $this->validateSpec($item->getSpec());
        }
    }

    private function validateSpec(Spec $spec): void
    {
        if (!$spec->getPlacement()) {
            $this->addError('Spec Placement is required');
        }
    }

    public function validateResponse(Response $response): bool
    {
        $this->reset();

        if (!$response->getId()) {
            $this->addError('Response ID is required');
        }

        return $this->isValid();
    }
}
