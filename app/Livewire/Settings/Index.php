<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithFileUploads;

    // General Settings
    public $app_name;
    public $app_description;
    public $contact_email;
    public $timezone;
    public $language;
    public $logo;
    public $current_logo;
    public $login_method;

        // Exam Settings
    public $default_test_duration;
    public $allow_late_submission;
    public $show_correct_answers;
    public $show_score_to_students;
    public $minimum_pass_score;
    public $enable_test_timer;

    // AI Settings
    public $ai_model;
    public $ai_temperature;
    public $ai_max_tokens;
    public $enable_ai_generator;

    // Security Settings
    public $enable_safe_browser;
    public $max_login_attempts;
    public $session_timeout;
    public $enable_cheating_detection;

    // Display Settings
    public $date_format;
    public $items_per_page;

    // UI State
    public $currentTab = 'general';

    public function mount()
    {
        // Check if user is admin
        if (auth()->user()->role->value !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $this->loadSettings();
    }

    public function loadSettings()
    {
        // General Settings
        $this->app_name = Setting::get('app_name', 'MowardCBT');
        $this->app_description = Setting::get('app_description', 'Computer Based Test System by MowardStudio');
        $this->contact_email = Setting::get('contact_email', 'admin@mowardcbt.com');
        $this->timezone = Setting::get('timezone', 'Asia/Jakarta');
        $this->language = Setting::get('language', 'id');
        $this->current_logo = Setting::get('app_logo', null);
        $this->login_method = Setting::get('login_method', 'email');

        // Exam Settings
        $this->default_test_duration = Setting::get('default_test_duration', 60);
        $this->allow_late_submission = Setting::get('allow_late_submission', false);
        $this->show_correct_answers = Setting::get('show_correct_answers', true);
        $this->show_score_to_students = Setting::get('show_score_to_students', true);
        $this->minimum_pass_score = Setting::get('minimum_pass_score', 60);
        $this->enable_test_timer = Setting::get('enable_test_timer', true);

        // AI Settings
        $this->ai_model = Setting::get('ai_model', 'gemini-1.5-flash');
        $this->ai_temperature = Setting::get('ai_temperature', 0.7);
        $this->ai_max_tokens = Setting::get('ai_max_tokens', 2048);
        $this->enable_ai_generator = Setting::get('enable_ai_generator', true);

        // Security Settings
        $this->enable_safe_browser = Setting::get('enable_safe_browser', true);
        $this->max_login_attempts = Setting::get('max_login_attempts', 5);
        $this->session_timeout = Setting::get('session_timeout', 120);
        $this->enable_cheating_detection = Setting::get('enable_cheating_detection', true);

        // Display Settings
        $this->date_format = Setting::get('date_format', 'd/m/Y');
        $this->items_per_page = Setting::get('items_per_page', 10);
    }

    public function switchTab($tab)
    {
        $this->currentTab = $tab;
    }

    public function openEdit()
    {
        $this->loadSettings();
        $this->dispatch('open-modal', 'settings-modal');
    }

    public function save()
    {
        // Validate all settings
        $this->validate([
            // General
            'app_name' => 'required|string|max:255',
            'app_description' => 'nullable|string|max:500',
            'contact_email' => 'required|email|max:255',
            'ai_max_tokens' => 'required|integer|min:100|max:8000',
            'enable_ai_generator' => 'boolean',

            // Security
            'enable_safe_browser' => 'boolean',
            'max_login_attempts' => 'required|integer|min:1|max:10',
            'session_timeout' => 'required|integer|min:5|max:1440',
            'enable_cheating_detection' => 'boolean',

            // Display
            'date_format' => 'required|string',
            'items_per_page' => 'required|integer|min:5|max:100',
        ]);

        // Save General Settings
        Setting::set('app_name', $this->app_name, 'string', 'general', 'Application name displayed throughout the system');
        Setting::set('app_description', $this->app_description, 'string', 'general', 'Application description');
        Setting::set('contact_email', $this->contact_email, 'string', 'general', 'Contact email for support');
        Setting::set('timezone', $this->timezone, 'string', 'general', 'Application timezone');
        Setting::set('language', $this->language, 'string', 'general', 'Default application language');
        Setting::set('login_method', $this->login_method, 'string', 'general', 'Login method (email or username)');

        // Save Logo if uploaded
        if ($this->logo) {
            $logoPath = $this->logo->store('logos', 'public');
            Setting::set('app_logo', $logoPath, 'string', 'general', 'Application logo path');
            $this->current_logo = $logoPath;
        }

        // Save Exam Settings
        Setting::set('default_test_duration', $this->default_test_duration, 'number', 'exam', 'Default test duration in minutes');
        Setting::set('allow_late_submission', $this->allow_late_submission, 'boolean', 'exam', 'Allow students to submit test after deadline');
        Setting::set('show_correct_answers', $this->show_correct_answers, 'boolean', 'exam', 'Show correct answers to students after test completion');
        Setting::set('show_score_to_students', $this->show_score_to_students, 'boolean', 'exam', 'Show numeric score to students in test results');
        Setting::set('minimum_pass_score', $this->minimum_pass_score, 'number', 'exam', 'Minimum score to pass a test (percentage)');
        Setting::set('enable_test_timer', $this->enable_test_timer, 'boolean', 'exam', 'Enable countdown timer during tests');

        // Save AI Settings
        Setting::set('ai_model', $this->ai_model, 'string', 'ai', 'AI model for question generation');
        Setting::set('ai_temperature', $this->ai_temperature, 'number', 'ai', 'AI temperature for response randomness (0.0 - 1.0)');
        Setting::set('ai_max_tokens', $this->ai_max_tokens, 'number', 'ai', 'Maximum tokens for AI responses');
        Setting::set('enable_ai_generator', $this->enable_ai_generator, 'boolean', 'ai', 'Enable AI-powered question generator');

        // Save Security Settings
        Setting::set('enable_safe_browser', $this->enable_safe_browser, 'boolean', 'security', 'Require safe browser for taking tests');
        Setting::set('max_login_attempts', $this->max_login_attempts, 'number', 'security', 'Maximum login attempts before lockout');
        Setting::set('session_timeout', $this->session_timeout, 'number', 'security', 'Session timeout in minutes');
        Setting::set('enable_cheating_detection', $this->enable_cheating_detection, 'boolean', 'security', 'Enable cheating detection during tests');

        // Save Display Settings
        Setting::set('date_format', $this->date_format, 'string', 'display', 'Date format for displaying dates throughout the application');
        Setting::set('items_per_page', $this->items_per_page, 'number', 'display', 'Number of items to display per page in tables and lists');

        $this->logo = null;
        $this->dispatch('close-modal', 'settings-modal');
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Settings saved successfully!']);
    }

    public function removeLogo()
    {
        if ($this->current_logo) {
            // Delete old logo file
            if (\Storage::disk('public')->exists($this->current_logo)) {
                \Storage::disk('public')->delete($this->current_logo);
            }
            
            Setting::set('app_logo', null, 'string', 'general', 'Application logo path');
            $this->current_logo = null;
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Logo removed successfully!']);
        }
    }

    public function resetToDefaults()
    {
        // Re-run the seeder to reset all settings to defaults
        \Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\SettingsSeeder', '--force' => true]);
        
        $this->loadSettings();
        $this->dispatch('close-modal', 'settings-modal');
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Settings reset to defaults successfully!']);
    }

    public function render()
    {
        return view('livewire.settings.index');
    }
}
