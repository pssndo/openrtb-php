<?php

declare(strict_types=1);

namespace OpenRTB\v26\Util;

use OpenRTB\v26\BidRequest;
use OpenRTB\v26\Impression\Imp;

/**
 * Validator for OpenRTB 2.6 objects.
 */
class Validator
{
    /** @var list<string> */
    private array $errors = [];

    public function validateBidRequest(BidRequest $request): bool
    {
        $this->errors = [];

        if (!$request->getId()) {
            $this->errors[] = 'Request ID is required';
        }

        $items = $request->getImp();
        if (empty($items)) {
            $this->errors[] = 'Request must contain at least one Imp object';
        } else {
            foreach ($items as $item) {
                $this->validateImp($item);
            }
        }

        return empty($this->errors);
    }

    private function validateImp(Imp $imp): void
    {
        if (!$imp->getId()) {
            $this->errors[] = 'Imp ID is required';
        }

        if (!$imp->getBanner() && !$imp->getVideo() && !$imp->getAudio() && !$imp->getNative()) {
            $this->errors[] = sprintf('Imp (ID: %s) must contain at least one of Banner, Video, Audio, or Native', $imp->getId());
        }
    }

    /** @return list<string> */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
