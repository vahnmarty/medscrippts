<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BlurSetting extends Enum
{
    const Pathophysiology = 'Path';
    const Epidemiology = 'Epi';
    const SignsAndSymptoms = 'SS';
    const Diagnosis = 'Dx';
    const Treatments = 'Tx';
}
