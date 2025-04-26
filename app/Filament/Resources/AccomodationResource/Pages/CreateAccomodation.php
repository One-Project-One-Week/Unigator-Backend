<?php

namespace App\Filament\Resources\AccomodationResource\Pages;

use App\Filament\Resources\AccomodationResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateAccomodation extends CreateRecord
{
    protected static string $resource = AccomodationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['university_id'] = auth()->user()->university->id;
        return $data;
    }

    protected function beforeCreate(): void
    {
        $user = auth()->user();

        $university = $user->university;

        if ($university && $university->accommodations()->count() >= 2) {
            Notification::make()
                ->title('You can only have 2 accommodations')
                ->danger()
                ->send();

            $this->halt();

            $this->redirect(AccomodationResource::getUrl('index'));
        }
    }
}