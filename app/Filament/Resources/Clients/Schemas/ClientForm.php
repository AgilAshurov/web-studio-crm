<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('company_name')
                    ->required(),
                TextInput::make('website_url')
                    ->url(),
                Textarea::make('server_info')
                    ->columnSpanFull(),
                TextInput::make('billing_contact'),
                TextInput::make('tech_contact'),
            ]);
    }
}
