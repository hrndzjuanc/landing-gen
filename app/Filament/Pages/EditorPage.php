<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Landing;

class EditorPage extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.pages.editor-page';

    public ?Landing $landing;

    public function mount()
    {
        $this->landing = Landing::find(request()->id);
    }

    public function getTitle(): string
    {
        return '';
    }
}
