<?php

namespace App\Filament\Resources\AccomodationResource\Pages;

use App\Filament\Resources\AccomodationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccomodations extends ListRecords
{
    protected static string $resource = AccomodationResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [];

        if (auth()->user()->university->accommodations()->count() < 2) {
            $actions[] = Actions\CreateAction::make();
        }

        return $actions;
    }
}