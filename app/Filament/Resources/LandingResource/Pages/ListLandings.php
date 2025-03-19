<?php

namespace App\Filament\Resources\LandingResource\Pages;

use App\Filament\Resources\LandingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLandings extends ListRecords
{
    protected static string $resource = LandingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('create')
            ->label('Crear')
            ->icon('heroicon-m-plus')
            ->action(fn()=> self::createEmptyLanding()),
        ];
    }
    public static function createEmptyLanding()
    {
        $next_landing_id = \App\Models\Landing::max('id') + 1;
        $landing = \App\Models\Landing::create([
            'landing_name' => 'Landing ' . $next_landing_id,
            'subdomain' => 'landing' . $next_landing_id,
            'header_type' => '1',
            'footer_type' => '1',
            'body' => view('porsche.porsche_default_body')->render(),
            'links' => [
            ],
        ]);
        return redirect()->route('filament.admin.resources.landings.edit', $landing->id);
    }
}
