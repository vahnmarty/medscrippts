<?php

namespace App\Filament\Resources\ScriptResource\Pages;

use App\Filament\Resources\ScriptResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditScript extends EditRecord
{
    protected static string $resource = ScriptResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
