<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Section: Content
            Forms\Components\Section::make('Content')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($operation, $state, $set) {
                            if ($operation === 'edit') {
                                return;
                            }
                            $set('slug', Str::slug($state));
                        }),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(Article::class, 'slug', ignoreRecord: true)
                        ->disabled(fn ($operation) => $operation === 'edit')
                        ->helperText('Auto-generated from title, editable only during creation'),
                    Forms\Components\RichEditor::make('body')
                        ->required()
                        ->fileAttachmentsDirectory('article-attachments')
                        ->toolbarButtons([
                            'blockquote', 'bold', 'bulletList', 'codeBlock', 'h2', 'h3',
                            'italic', 'link', 'orderedList', 'redo', 'strike', 'underline', 'undo',
                        ])
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('excerpt')
                        ->rows(3)
                        ->maxLength(500)
                        ->helperText('Brief summary for article preview'),
                ])
                ->columns(2),

            // Section: SEO Settings
            Forms\Components\Section::make('SEO Settings')
                ->schema([
                    Forms\Components\TextInput::make('meta_title')
                        ->maxLength(255)
                        ->helperText('If empty, title will be used'),
                    Forms\Components\Textarea::make('meta_description')
                        ->rows(2)
                        ->maxLength(255)
                        ->helperText('If empty, excerpt will be used'),
                ])
                ->columns(1),

            // Section: Settings
            Forms\Components\Section::make('Settings')
                ->schema([
                    // FileUpload untuk gambar - Sekarang menggunakan ImgurService
                    Forms\Components\FileUpload::make('image')
                        ->label('Featured Image')
                        ->image()
                        ->imageEditor()
                        ->directory('uploads/temp')
                        ->disk('public')
                        ->maxSize(5120) // 5MB
                        ->acceptedFileTypes(['image/jpeg','image/png','image/gif'])
                        ->helperText('Image will be uploaded to Imgur when saved')
                        ->saveUploadedFileUsing(function ($file) {
                            $imgurService = app(ImgurService::class);
                            $url = $imgurService->upload($file);

                            // Pastikan ini adalah direct link
                            if (strpos($url, 'https://i.imgur.com/') === false && !empty($url)) {
                                // Ekstrak ID gambar jika URL bukan direct link
                                $parts = explode('/', $url);
                                $id = end($parts);
                                $id = str_replace(['.jpg', '.png', '.gif'], '', $id);
                                return "https://i.imgur.com/{$id}.png";
                            }

                            return $url;
                        })
                        ->deleteUploadedFileUsing(function ($file) {
                            // This could be extended to delete from Imgur if needed
                            Storage::disk('public')->delete($file);
                        }),

                    // Toggle untuk publish langsung
                    Forms\Components\Toggle::make('publish_now')
                        ->label('Publish Immediately')
                        ->default(true)
                        ->reactive()
                        ->afterStateHydrated(function ($component, $record) {
                            if ($record) {
                                // Jika published_at sudah terlewat atau sama dengan waktu sekarang,
                                // berarti artikel sudah dipublish
                                $component->state(
                                    $record->published_at === null ||
                                    now()->greaterThanOrEqualTo($record->published_at)
                                );
                            }
                        })
                        ->dehydrated(false)
                        ->helperText('If enabled, the article will be published immediately with current date/time.'),

                    // DateTimePicker untuk penjadwalan publikasi; tampil jika publish_now false
                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('Scheduled Publication')
                        ->default(now()->setTimezone('Asia/Jakarta'))
                        ->displayFormat('d M Y, H:i')
                        ->helperText('Schedule publication date/time')
                        ->visible(fn (callable $get) => $get('publish_now') === false),

                    // Select untuk tags dengan opsi membuat tag baru
                    Forms\Components\Select::make('tags')
                        ->relationship('tags', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->unique(Tag::class, 'name')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state))),
                            Forms\Components\TextInput::make('slug')
                                ->required()
                                ->maxLength(255)
                                ->unique(Tag::class, 'slug'),
                        ]),
                ])
                ->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image')
                ->label('Featured Image')
                ->size(60)
                ->toggleable(),
            Tables\Columns\TextColumn::make('title')
                ->searchable()
                ->sortable()
                ->wrap()
                ->description(fn (Article $record) => $record->slug),
            Tables\Columns\TextColumn::make('published_at')
                ->label('Status')
                ->dateTime('d M Y, H:i')
                ->sortable()
                ->toggleable()
                ->formatStateUsing(function ($state, $record) {
                    // Gunakan timezone Asia/Jakarta (UTC+7)
                    $tz = new \DateTimeZone('Asia/Jakarta');
                    $publishedAt = $record->published_at ? $record->published_at->setTimezone($tz) : null;
                    $now = now($tz);

                    if ($publishedAt && $now->greaterThanOrEqualTo($publishedAt)) {
                        return 'Article Published';
                    }

                    if ($publishedAt && $now->lessThan($publishedAt)) {
                        return 'Scheduled: ' . $publishedAt->format('d M Y, H:i');
                    }

                    return 'Article Published';
                })
                ->color(function ($record) {
                    $tz = new \DateTimeZone('Asia/Jakarta');
                    $publishedAt = $record->published_at ? $record->published_at->setTimezone($tz) : null;
                    $now = now($tz);

                    if ($publishedAt && $now->greaterThanOrEqualTo($publishedAt)) {
                        return 'success';
                    }

                    if ($publishedAt && $now->lessThan($publishedAt)) {
                        return 'warning';
                    }

                    return 'success';
                })
                ->badge(),

            Tables\Columns\TextColumn::make('tags.name')
                ->badge()
                ->color('gray')
                ->toggleable(),
        ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                // Filter "published": tampilkan artikel yang sudah dipublish (published_at <= now)
                Tables\Filters\Filter::make('published')
                    ->label('Published')
                    ->query(fn ($query) => $query->where('published_at', '<=', now())),

                // Filter "scheduled": artikel yang dijadwalkan (published_at > now)
                Tables\Filters\Filter::make('scheduled')
                    ->label('Scheduled')
                    ->query(fn ($query) => $query->where('published_at', '>', now())),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit'),
                Tables\Actions\ViewAction::make()
                    ->iconButton()
                    ->tooltip('Preview'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit'   => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
