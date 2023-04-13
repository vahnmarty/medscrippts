<?php declare(strict_types=1);

namespace App\Enums;
use BenSampo\Enum\Attributes\Description;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BlurSetting extends Enum
{   
    #[Description('Pathophysiology')]
    const pathophysiology = 'Path';

    #[Description('Epidemiology')]
    const epidemiology = 'Epi';

    #[Description('Signs And Symptoms')]
    const signs = 'SS';

    #[Description('Diagnosis')]
    const diagnosis = 'Dx';

    #[Description('Treatments')]
    const treatments = 'Tx';
}
