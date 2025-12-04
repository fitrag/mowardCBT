<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'app_name',
                'value' => 'MowardCBT',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Application name displayed throughout the system',
            ],
            [
                'key' => 'app_description',
                'value' => 'Computer Based Test System by MowardStudio',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Application description',
            ],
            [
                'key' => 'contact_email',
                'value' => 'admin@mowardcbt.com',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Contact email for support',
            ],
            [
                'key' => 'timezone',
                'value' => 'Asia/Jakarta',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Application timezone',
            ],
            [
                'key' => 'language',
                'value' => 'id',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Default application language',
            ],
            [
                'key' => 'login_method',
                'value' => 'email',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Login method (email or username)',
            ],

            // Exam Settings
            [
                'key' => 'default_test_duration',
                'value' => '60',
                'type' => 'number',
                'group' => 'exam',
                'description' => 'Default test duration in minutes',
            ],
            [
                'key' => 'allow_late_submission',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'exam',
                'description' => 'Allow students to submit test after deadline',
            ],
            [
                'key' => 'show_correct_answers',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'exam',
                'description' => 'Show correct answers to students after test completion',
            ],
            [
                'key' => 'show_score_to_students',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'exam',
                'description' => 'Show numeric score to students in test results',
            ],
            [
                'key' => 'minimum_pass_score',
                'value' => '60',
                'type' => 'number',
                'group' => 'exam',
                'description' => 'Minimum score to pass a test (percentage)',
            ],
            [
                'key' => 'enable_test_timer',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'exam',
                'description' => 'Enable countdown timer during tests',
            ],

            // AI Settings
            [
                'key' => 'ai_model',
                'value' => 'gemini-1.5-flash',
                'type' => 'string',
                'group' => 'ai',
                'description' => 'AI model for question generation',
            ],
            [
                'key' => 'ai_temperature',
                'value' => '0.7',
                'type' => 'number',
                'group' => 'ai',
                'description' => 'AI temperature for response randomness (0.0 - 1.0)',
            ],
            [
                'key' => 'ai_max_tokens',
                'value' => '2048',
                'type' => 'number',
                'group' => 'ai',
                'description' => 'Maximum tokens for AI responses',
            ],
            [
                'key' => 'enable_ai_generator',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'ai',
                'description' => 'Enable AI-powered question generator',
            ],

            // Security Settings
            [
                'key' => 'enable_safe_browser',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'security',
                'description' => 'Require safe browser for taking tests',
            ],
            [
                'key' => 'max_login_attempts',
                'value' => '5',
                'type' => 'number',
                'group' => 'security',
                'description' => 'Maximum login attempts before lockout',
            ],
            [
                'key' => 'session_timeout',
                'value' => '120',
                'type' => 'number',
                'group' => 'security',
                'description' => 'Session timeout in minutes',
            ],
            [
                'key' => 'enable_cheating_detection',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'security',
                'description' => 'Enable cheating detection during tests',
            ],

            // Display Settings
            [
                'key' => 'date_format',
                'value' => 'd/m/Y',
                'type' => 'string',
                'group' => 'display',
                'description' => 'Date format for displaying dates throughout the application',
            ],
            [
                'key' => 'items_per_page',
                'value' => '10',
                'type' => 'number',
                'group' => 'display',
                'description' => 'Number of items to display per page in tables and lists',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
