<?php

namespace App\Filament\Pages;

use Exception;
use Filament\Facades\Filament;
use Filament\Forms\Components\Section;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.edit-profile';

    public ?array $profileData = [];
    public ?array $universityData = [];

    public function mount(): void
    {
        $this->fillForms();
    }

    public function getForms(): array
    {
        return [
            'editProfileForm',
            'editUniversityForm',
        ];
    }

    public function editProfileForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profile Information')
                    ->aside()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->label('University Name')
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),
                    ]),
            ])
            ->model($this->getUser())
            ->statePath('profileData');
    }

    public function editUniversityForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('University Information')
                    ->aside()
                    ->schema([
                        TextInput::make('description')
                            ->label('University Name')
                            ->required(),
                    ]),
            ])
            ->model($this->getUser()->university)
            ->statePath('universityData');
    }

    protected function getUser(): Authenticatable & Model
    {
        $user = Filament::auth()->user();
        if (! $user instanceof Model) {
            throw new Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }
        return $user;
    }

    protected function fillForms(): void
    {
        $data = $this->getUser()->attributesToArray();
        $this->editProfileForm->fill($data);

        if ($this->getUser()->university) {
            $this->editUniversityForm->fill($this->getUser()->university->toArray());
        }
    }

    protected function getUpdateProfileFormActions(): array
    {
        return [
            Action::make('updateProfileAction')
                ->label('Update Profile')
                ->submit('editProfileForm')
                ->color('primary'),
        ];
    }

    protected function getUpdateUniversityFormActions(): array
    {
        return [
            Action::make('updateUniversityAction')
                ->label('Update University')
                ->submit('editUniversityForm')
                ->color('primary'),
        ];
    }

    public function updateProfile(): void
    {
        $data = $this->editProfileForm->getState();
        $this->handleRecordUpdate($this->getUser(), $data);
        $this->sendSuccessNotification();
    }

    public function updateUniversity(): void
    {
        $data = $this->editUniversityForm->getState();
        $this->handleRecordUpdate($this->getUser()->university, $data);
        $this->sendSuccessNotification();
    }

    protected function sendSuccessNotification(): void
    {
        Notification::make()
            ->title('Profile updated successfully')
            ->success()
            ->send();
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);
        return $record;
    }
}