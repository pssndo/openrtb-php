<?php

declare(strict_types=1);

namespace OpenRTB\v26\Util;

use OpenRTB\Common\Util\AbstractValidator;
use OpenRTB\v26\BidRequest;
use OpenRTB\v26\Impression\Imp;

/**
 * Validator for OpenRTB 2.6 objects.
 */
class Validator extends AbstractValidator
{

    /**
     * Validates a BidRequest object.
     */
    public function validateBidRequest(BidRequest $request): bool
    {
        $this->reset();

        $this->validateRequestId($request);
        $this->validateImpressions($request);

        return $this->isValid();
    }

    /**
     * Validates the request ID.
     */
    private function validateRequestId(BidRequest $request): void
    {
        if (empty($request->getId())) {
            $this->addError('Request ID is required');
        }
    }

    /**
     * Validates impressions collection.
     */
    private function validateImpressions(BidRequest $request): void
    {
        $impressions = $request->getImp();

        if (empty($impressions)) {
            $this->addError('Request must contain at least one Imp object');
            return;
        }

        foreach ($impressions as $index => $impression) {
            // @phpstan-ignore-next-line - Defensive runtime check
            if (!$impression instanceof Imp) {
                $this->addError(sprintf(
                    'Invalid Imp object at index %d',
                    $index
                ));
                continue;
            }

            $this->validateImp($impression);
        }
    }

    /**
     * Validates an individual Imp object.
     */
    private function validateImp(Imp $imp): void
    {
        $this->validateImpId($imp);
        $this->validateImpMediaType($imp);
    }

    /**
     * Validates impression ID.
     */
    private function validateImpId(Imp $imp): void
    {
        if (empty($imp->getId())) {
            $this->addError('Imp ID is required');
        }
    }

    /**
     * Validates impression has at least one media type.
     */
    private function validateImpMediaType(Imp $imp): void
    {
        $hasMediaType = $imp->getBanner()
            || $imp->getVideo()
            || $imp->getAudio()
            || $imp->getNative();

        if (!$hasMediaType) {
            $impId = $imp->getId() ?: 'unknown';
            $this->addError(sprintf(
                'Imp (ID: %s) must contain at least one of Banner, Video, Audio, or Native',
                $impId
            ));
        }
    }

}
