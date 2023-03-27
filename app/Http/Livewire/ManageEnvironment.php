<?php

namespace App\Http\Livewire;

use File;
use Closure;
use Livewire\Component;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Filament\Forms\Concerns\InteractsWithForms;
use Artisan;

class ManageEnvironment extends Component implements HasForms
{
    use InteractsWithForms;

    use LivewireAlert;

    public $APP_TIMEZONE;
    public $FACEBOOK_ENABLE, $FACEBOOK_CLIENT_ID, $FACEBOOK_CLIENT_SECRET;
    public $TWITTER_ENABLE, $TWITTER_CLIENT_ID, $TWITTER_CLIENT_SECRET;
    public $GOOGLE_ENABLE, $GOOGLE_CLIENT_ID, $GOOGLE_CLIENT_SECRET;
    public $DB_CONNECTION;
    
    public function render()
    {
        return view('livewire.manage-environment');
    }

    public function mount()
    {
        $this->appForm->fill([
            'APP_TIMEZONE' => config('app.timezone'),
        ]); 

        $db_driver = config('database.default');

        $this->databaseForm->fill([
            'DB_CONNECTION' => $db_driver,
            'DB_HOST' => config('database.connections.' . $db_driver . '.host'),
            'DB_PORT' => config('database.connections.' . $db_driver . '.port'),
            'DB_DATABASE' => config('database.connections.' . $db_driver . '.database'),
            'DB_USERNAME' => config('database.connections.' . $db_driver . '.username'),
            'DB_PASSWORD' => config('database.connections.' . $db_driver . '.password'),
        ]);

        $this->facebookForm->fill([
            'FACEBOOK_ENABLE' => config('services.facebook.enable'),
            'FACEBOOK_CLIENT_ID' => config('services.facebook.client_id'),
            'FACEBOOK_CLIENT_SECRET' => config('services.facebook.client_secret'),
        ]);

        $this->twitterForm->fill([
            'TWITTER_ENABLE' => config('services.twitter.enable'),
            'TWITTER_CLIENT_ID' => config('services.twitter.client_id'),
            'TWITTER_CLIENT_SECRET' => config('services.twitter.client_secret'),
        ]);

        $this->googleForm->fill([
            'GOOGLE_ENABLE' => config('services.google.enable'),
            'GOOGLE_CLIENT_ID' => config('services.google.client_id'),
            'GOOGLE_CLIENT_SECRET' => config('services.google.client_secret'),
        ]);
    }

    protected function getForms(): array 
    {
        return [
            'appForm' => $this->makeForm()
                ->schema($this->getAppFormSchema()),
            'databaseForm' => $this->makeForm()
                ->schema($this->getDatabaseFormSchema()),
            'facebookForm' => $this->makeForm()
                ->schema($this->getFacebookFormSchema()),
            'twitterForm' => $this->makeForm()
                ->schema($this->getTwitterFormSchema()),
            'googleForm' => $this->makeForm()
                ->schema($this->getGoogleFormSchema()),
        ];
    }

    public function getAppFormSchema()
    {
        return [
            TextInput::make('APP_TIMEZONE')
            ->label('APP_TIMEZONE')
            ->hint('View the list of [timezones](https://www.php.net/manual/en/timezones.php)')
        ];
    }

    public function getDatabaseFormSchema()
    {
        return [
            TextInput::make('DB_CONNECTION')->label('DB_CONNECTION'),
            TextInput::make('DB_HOST')->label('DB_HOST'),
            TextInput::make('DB_PORT')->label('DB_PORT'),
            TextInput::make('DB_DATABASE')->label('DB_DATABASE'),
            TextInput::make('DB_USERNAME')->label('DB_USERNAME'),
            TextInput::make('DB_PASSWORD')->label('DB_PASSWORD'),
        ];
    }

    public function getFacebookFormSchema()
    {
        return [
            Toggle::make('FACEBOOK_ENABLE')->label('Enable')->reactive(),
            TextInput::make('FACEBOOK_CLIENT_ID')->label('FACEBOOK_CLIENT_ID')->disabled(fn (Closure $get) => !$get('FACEBOOK_ENABLE')),
            TextInput::make('FACEBOOK_CLIENT_SECRET')->label('FACEBOOK_CLIENT_SECRET')->disabled(fn (Closure $get) => !$get('FACEBOOK_ENABLE'))
        ];
    }

    public function getTwitterFormSchema()
    {
        return [
            Toggle::make('TWITTER_ENABLE')->label('Enable')->reactive(),
            TextInput::make('TWITTER_CLIENT_ID')->label('TWITTER_CLIENT_ID')->disabled(fn (Closure $get) => !$get('TWITTER_ENABLE')),
            TextInput::make('TWITTER_CLIENT_SECRET')->label('TWITTER_CLIENT_SECRET')->disabled(fn (Closure $get) => !$get('TWITTER_ENABLE'))
        ];
    }

    public function getGoogleFormSchema()
    {
        return [
            Toggle::make('GOOGLE_ENABLE')->label('Enable')->reactive(),
            TextInput::make('GOOGLE_CLIENT_ID')->label('GOOGLE_CLIENT_ID')->disabled(fn (Closure $get) => !$get('GOOGLE_ENABLE')),
            TextInput::make('GOOGLE_CLIENT_SECRET')->label('GOOGLE_CLIENT_SECRET')->disabled(fn (Closure $get) => !$get('GOOGLE_ENABLE'))
        ];
    }

    public function updateEnv($env, $value, $config = null)
    {
        $envFilePath = base_path('.env');

        if (File::exists($envFilePath)) {
            $envContent = File::get($envFilePath);

            // replace the value of the config variable
            $envContent = preg_replace('/^' . $env . '=.*/m', $env . '=' . $value, $envContent);

            // write the updated content to the .env file
            try {
                File::put($envFilePath, $envContent);
                Artisan::call('config:cache');

                $this->alert('success', "Success! The {$env} environment variable has been updated. Please note that changes may not be reflected immediately. If you do not see the new value, please wait a few minutes and refresh the page.");

                $this->$env = config($config);
                
                # Hard Refresh
                //return redirect(request()->header('Referer'));

            } catch (\Throwable $th) {
                throw $th;
            }
        
        }
    }

    public function saveAppForm()
    {
        $data = $this->appForm->getState();

        $this->updateEnv('APP_TIMEZONE', $data['APP_TIMEZONE'], 'app.timezone' );
    }
}
