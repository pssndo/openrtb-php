<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Placement;

/**
 * The following table lists the various volume normalization modes.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--volume-normalization-modes-
 */
enum VolumeNormalizationMode: int
{
    case NONE = 0;
    case AD_VOLUME_AVERAGE = 1;
    case AD_VOLUME_PEAK = 2;
    case AD_LOUDNESS = 3;
    case CUSTOM_VOLUME = 4;
}
