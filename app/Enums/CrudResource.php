<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CrudResource extends Enum
{
    const Create = 1;
    const Read = 2;
    const Update = 3;
    const Delete = 4;
}
