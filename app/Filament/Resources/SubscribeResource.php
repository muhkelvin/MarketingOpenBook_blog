<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscribeResource\Pages;
use App\Models\Subscribe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubscribeResource extends Resource
{
    protected static ?string $model = Subscribe::class;

    protected static ?string $navigationIcon = 'heroicon-o-at-symbol';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 4;
    protected static ?string $recordTitleAttribute = 'email';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Subscription Details')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(Subscribe::class, 'email', ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'This email is already subscribed',
                            ]),
                    ])
                    ->columns(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Subscribed on')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('export')
                    ->label('Export Selected')
                    ->action(function ($records) {
                        $records = $records->all();
                        $filename = 'subscribes_export_' . now()->format('Y_m_d_H_i_s') . '.csv';
                        $filepath = storage_path("app/{$filename}");
                        $handle = fopen($filepath, 'w+');

                        // Tulis header CSV
                        fputcsv($handle, ['Email', 'Subscribed On']);

                        // Tulis data per record
                        foreach ($records as $record) {
                            fputcsv($handle, [
                                $record->email,
                                $record->created_at,
                            ]);
                        }

                        fclose($handle);
                        return response()->download($filepath)->deleteFileAfterSend(true);
                    })
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion()
                    ->color('primary'),
            ])
            ->emptyStateActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscribes::route('/'),
        ];
    }
}
