<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 3;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contact Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('message')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('message')
                    ->searchable()
                    ->toggleable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Hanya menyertakan action view untuk melihat detail pesan
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('export')
                    ->label('Export Selected')
                    ->action(function ($records) {
                        // Konversi Collection menjadi array
                        $records = $records->all();
                        $filename = 'contacts_export_' . now()->format('Y_m_d_H_i_s') . '.csv';
                        $filepath = storage_path("app/{$filename}");
                        $handle = fopen($filepath, 'w+');

                        // Tulis header CSV
                        fputcsv($handle, ['Name', 'Email',  'Message', 'Created At']);

                        // Tulis data per record
                        foreach ($records as $record) {
                            fputcsv($handle, [
                                $record->name,
                                $record->email,
                                $record->message,
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
            ->emptyStateActions([]); // Hilangkan tombol create jika kosong
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
            // Hanya ada halaman index
            'index' => Pages\ListContacts::route('/'),
        ];
    }
}
