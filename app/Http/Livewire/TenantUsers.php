<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Concerns\InteractsWithTable;

class TenantUsers extends Component implements HasTable
{
    use InteractsWithTable;
    
    public function render()
    {
        return view('livewire.tenant-users');
    }

    protected function getTableQuery() 
    {
        return User::query();
    } 

    protected function getTableColumns(): array 
    {
        return [
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('email')->searchable()->sortable(),
            TextColumn::make('roles.display_name'),
            TextColumn::make('created_at')->dateTime('F d, Y')
            
        ];
    }

    protected function getTableActions()
    {
        return [
            ActionGroup::make([
                EditAction::make()
                ->form([
                    TextInput::make('name')
                ])
            ])

            
        ];
    }
}
