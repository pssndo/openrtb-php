<?php

declare(strict_types=1);

namespace OpenRTB\v3\Enums\Bid;

/**
 * The following table lists the creative attributes that can describe an ad.
 *
 * @see https://github.com/InteractiveAdvertisingBureau/AdCOM/blob/master/AdCOM%20v1.0%20FINAL.md#list--creative-attributes-
 */
enum CreativeAttribute: int
{
    case ONE_POOR = 1;          // 1 Audio Ad (Auto-Play)
    case TWO_POOR = 2;          // 2 Audio Ad (User Initiated)
    case THREE_EXPANDABLE = 3;      // 3 Expandable (Automatic)
    case FOUR_EXPANDABLE = 4;     // 4 Expandable (User Initiated - Click)
    case FIVE_EXPANDABLE = 5;     // 5 Expandable (User Initiated - Rollover)
    case SIX_IN_BANNER = 6;     // 6 In-Banner Video Ad (Auto-Play)
    case SEVEN_IN_BANNER = 7;   // 7 In-Banner Video Ad (User Initiated)
    case EIGHT_POP = 8;         // 8 Pop (e.g., Over, Under, or Upon Exit)
    case NINE_PROVOCATIVE = 9;    // 9 Provocative or Suggestive Imagery
    case TEN_EXTREME = 10;        // 10 Extreme Animation (e.g., Shaking, Flashing, etc.)
    case ELEVEN_SURVEYS = 11;       // 11 Surveys
    case TWELVE_TEXT_ONLY = 12;     // 12 Text Only
    case THIRTEEN_USER_INTERACTIVE = 13; // 13 User Interactive (e.g., Embedded Games)
    case FOURTEEN_WINDOWS_DIALOG = 14; // 14 Windows Dialog or Alert Style
    case FIFTEEN_HAS_AUDIO = 15;    // 15 Has Audio On/Off Button
    case SIXTEEN_AD_PROVIDES = 16;  // 16 Ad Provides Skip Button (e.g., VPAID-rendered ad)
    case SEVENTEEN_ADOBE_FLASH = 17; // 17 Adobe Flash
}
