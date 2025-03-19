<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LandingResource\Pages;
use App\Filament\Resources\LandingResource\RelationManagers;
use App\Models\Landing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action as FormAction;
use App\Filament\Resources\LandingResource\Pages\ListLandings;
use Illuminate\Support\Facades\Http;

class LandingResource extends Resource
{
    protected static ?string $model = Landing::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('landing_name')
                    ->label('Nombre del landing')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('subdomain')
                    ->label('Subdominio')
                    ->required()
                    ->maxLength(255)
                    ->regex('/^[a-z0-9]+$/')
                    ->helperText('Solo letras minúsculas y números permitidos'),

                    // HEADER
                    Forms\Components\Section::make('Header')
                    ->schema([
                        Forms\Components\Grid::make(1)
                            ->schema([
                                Forms\Components\Radio::make('header_type')
                                    ->label('Selecciona el tipo de header')
                                    ->options([
                                        '1' => 'Enlaces ocultos en menú desplegable (Claro)',
                                        '3' => 'Enlaces visibles (Claro)',
                                        '2' => 'Enlaces ocultos en menú desplegable (Oscuro)',
                                        '4' => 'Enlaces visibles (Oscuro)',
                                    ])
                                    ->descriptions([
                                        '1' => new \Illuminate\Support\HtmlString('<img src="/img/header1.png" class="w-full h-auto cursor-pointer" />'),
                                        '2' => new \Illuminate\Support\HtmlString('<img src="/img/header2.png" class="w-full h-auto cursor-pointer" />'),
                                        '3' => new \Illuminate\Support\HtmlString('<img src="/img/header3.png" class="w-full h-auto cursor-pointer" />'),
                                        '4' => new \Illuminate\Support\HtmlString('<img src="/img/header4.png" class="w-full h-auto cursor-pointer" />')
                                    ])
                                    ->extraAttributes(['class' => 'border-2 border-gray-200 rounded-lg p-2 mt-2'])
                                    ->columns(2)
                                    ->required(),

                                // Sección añadida para enlaces dinámicos
                                Forms\Components\Repeater::make('links')
                                    ->label('Enlaces')
                                    ->schema([
                                        Forms\Components\TextInput::make('link_name')
                                            ->label('Nombre de enlace')
                                            ->required(),
                                        Forms\Components\TextInput::make('link_url')
                                            ->label('Url del enlace')
                                            ->required()
                                            ->url(),
                                    ])
                                    ->createItemButtonLabel('Añadir enlace')
                                    ->disableItemCreation(false)
                                    ->columns(2),
                            ]),
                    ]),

                    // CONTENIDO
                    Forms\Components\Section::make('Cuerpo')
                    ->schema([
                        Actions::make([
                            FormAction::make('editar_cuerpo')
                                ->label('Editar Cuerpo')
                                ->icon('heroicon-m-pencil')
                                ->action(function ($record) {
                                    return redirect()->route('page-editor', $record->id);
                                })
                                ->openUrlInNewTab(),
                        ]),
                    ]),

                    // FOOTER
                    Forms\Components\Section::make('Footer')
                    ->schema([
                        Forms\Components\Grid::make(1)
                            ->schema([
                                Forms\Components\Radio::make('footer_type')
                                    ->label('Selecciona el tipo de footer')
                                    ->options([
                                        '1' => 'Simple claro',
                                        '3' => 'Completo (Claro)',
                                        '2' => 'Simple (Oscuro)',
                                        '4' => 'Completo (Oscuro)',
                                    ])
                                    ->descriptions([
                                        '1' => new \Illuminate\Support\HtmlString('<img src="/img/footer1.png" class="w-full h-auto cursor-pointer" />'),
                                        '2' => new \Illuminate\Support\HtmlString('<img src="/img/footer2.png" class="w-full h-auto cursor-pointer" />'),
                                        '3' => new \Illuminate\Support\HtmlString('<img src="/img/footer3.png" class="w-full h-auto cursor-pointer" />'),
                                        '4' => new \Illuminate\Support\HtmlString('<img src="/img/footer4.png" class="w-full h-auto cursor-pointer" />')
                                    ])
                                    ->extraAttributes(['class' => 'border-2 border-gray-200 rounded-lg p-2 mt-2'])
                                    ->columns(2)
                                    ->required(),
                                Forms\Components\Textarea::make('footer_text')
                                    ->label('Texto en el footer')
                                    ->rows(4)
                                    ->maxLength(1000)
                                    ->helperText('Texto adicional que aparecerá en el footer')
                            ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('landing_name')
                    ->label('Nombre de la Landing'),
                    Tables\Columns\TextColumn::make('subdomain')
                        ->label('Subdominio'),
                    Tables\Columns\TextColumn::make('subdomain_id')
                        ->label('ID del subdominio'),
                    Tables\Columns\TextColumn::make('created_at')
                        ->label('Fecha de creación')
                        ->dateTime('d-m-Y H:i:s'),
                    IconColumn::make('is_published')
                        ->label('Publicado')
                        ->icon(fn (string $state): string => match ($state) {
                            '1' => 'heroicon-o-check-circle',
                            '0' => 'heroicon-o-x-circle',
                        })
                        ->color(fn (string $state): string => match ($state) {
                            '1' => 'success',
                            '0' => 'danger',
                        })

            ])
            ->emptyStateActions([
                Action::make('create')
                    ->label('Crear')
                    ->action(fn () => ListLandings::createEmptyLanding())
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([

                    // Visitar
                    Action::make('visitar')
                        ->label('Visitar')
                        ->icon('heroicon-m-arrow-right')
                        ->hidden(fn ($record) => !$record->is_published)
                        ->url(fn ($record) => "/{$record->subdomain}")
                        ->openUrlInNewTab(),

                    // Publicar
                    Action::make('publicar')
                        ->label('Publicar')
                        ->icon('heroicon-m-arrow-up-circle')
                        ->hidden(fn ($record) => $record->is_published)
                        ->action(function ($record) {
                            $record->is_published = true;
                            $record->save();
                        }),

                    Action::make('despublicar')
                        ->label('Despublicar')
                        ->icon('heroicon-m-arrow-down-circle')
                        ->hidden(fn ($record) => !$record->is_published)
                        ->action(function ($record) {
                            $record->is_published = false;
                            $record->save();
                        }),

                    // Preview
                    Action::make('previsualizar')
                    ->icon('heroicon-m-magnifying-glass')
                    ->url(fn ($record) => route('page-preview', ['id' => $record->id])),

                    // Editar 1
                    Tables\Actions\EditAction::make(),

                    // Editar 2
                    Action::make('editar_cuerpo')
                    ->label('Editar Cuerpo')
                    ->icon('heroicon-m-pencil')
                    ->url(fn ($record) => route('page-editor', ['id' => $record->id])),

                    // Eliminar
                    Tables\Actions\DeleteAction::make(),
                ])->iconButton()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListLandings::route('/'),
            'create' => Pages\CreateLanding::route('/create'),
            'edit' => Pages\EditLanding::route('/{record}/edit'),
        ];
    }
    
}
