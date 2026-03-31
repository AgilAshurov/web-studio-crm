<?php

namespace App\Filament\Resources\Clients;



use App\Filament\Resources\Clients\Pages\CreateClient;
use App\Filament\Resources\Clients\Pages\EditClient;
use App\Filament\Resources\Clients\Pages\ListClients;
use App\Filament\Resources\Clients\Pages\ViewClient;
use App\Filament\Resources\Clients\Schemas\ClientForm;
use App\Filament\Resources\Clients\Schemas\ClientInfolist;
use App\Filament\Resources\Clients\Tables\ClientsTable;
use App\Models\Client;
use App\Http\Controllers\Admin\ClientController;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Actions\Action; // ✅ правильно
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;// 👈 правильный импорт
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;


class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'company_name';

    public static function form(Schema $schema): Schema
    {
        return ClientForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ClientInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientsTable::configure($table)
            ->recordActions([
                Action::make('edit')
                    ->label('Редактировать')
                    ->url(fn (Client $record) => EditClient::getUrl([$record->getKey()])),

                Action::make('view')
                    ->label('Просмотр')
                    ->url(fn (Client $record) => ViewClient::getUrl([$record->getKey()])),

                Action::make('delete')
                    ->label('Удалить')
                    ->requiresConfirmation()
                    ->action(fn (Client $record) =>
                    app(ClientController::class)->destroy($record)
                    ),

                Action::make('customUpdate')
                    ->label('Обновить через контроллер')
                    ->form(fn () => ClientForm::configure(new Schema()))
                    ->action(fn (Client $record, array $data) =>
                    app(ClientController::class)->update(request(), $record)
                    ),
            ])
            ->headerActions([
                Action::make('create')
                    ->label('Создать клиента')
                    ->form([
                        TextInput::make('company_name')->required(),
                        TextInput::make('website_url')->required(),
                    ])
                    ->action(fn (array $data) =>
                    app(ClientController::class)->store(request()->merge($data))
                    ),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClients::route('/'),
            'create' => CreateClient::route('/create'),
            'view' => ViewClient::route('/{record}'),
            'edit' => EditClient::route('/{record}/edit'),
        ];
    }
}
