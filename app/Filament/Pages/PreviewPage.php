<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Landing;
class PreviewPage extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.pages.preview-page';

    public ?Landing $landing;

    public function getTitle(): string
    {
        return 'Previsualizar '. $this->landing->landing_name;
    }

    public function mount()
    {
        $this->landing = Landing::find(request()->id);
    }
}