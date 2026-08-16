<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SetupWizardController extends Controller
{
    /**
     * Show the first boot setup wizard.
     */
    public function show()
    {
        $flagPath = storage_path('app/first_boot.json');
        if (file_exists($flagPath)) {
            $data = json_decode(file_get_contents($flagPath), true);
            if (!empty($data['setup_complete'])) {
                return redirect()->route('dashboard');
            }
        }

        return view('setup.wizard');
    }

    /**
     * Handle the submission of the setup wizard.
     */
    public function store(Request $request)
    {
        $request->validate([
            'database_path' => 'required|string',
        ]);

        $dbPath = $request->database_path;

        // Ensure the directory exists
        if (!File::exists($dbPath)) {
            File::makeDirectory($dbPath, 0755, true, true);
        }

        // The exact file path for SQLite
        $sqliteFile = rtrim($dbPath, '/\\') . DIRECTORY_SEPARATOR . 'database.sqlite';

        // Create the file if it doesn't exist
        if (!File::exists($sqliteFile)) {
            touch($sqliteFile);
        }

        // Write to .env
        $this->updateEnvFile('DB_DATABASE', $sqliteFile);

        // Update the current configuration so migrations use it
        config(['database.connections.sqlite.database' => $sqliteFile]);
        config(['database.default' => 'sqlite']);

        // Forcibly purge the old sqlite connection to use the new runtime config
        \Illuminate\Support\Facades\DB::purge('sqlite');

        // Run migrations
        Artisan::call('migrate', ['--force' => true]);

        // Mark setup as complete
        $flagPath = storage_path('app/first_boot.json');
        File::put($flagPath, json_encode(['setup_complete' => true]));

        return redirect()->route('dashboard')->with('success', __('تم إعداد قاعدة البيانات بنجاح'));
    }

    /**
     * Update an environment variable in the .env file.
     */
    protected function updateEnvFile($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            // Read the current .env contents
            $env = file_get_contents($path);

            // Escape value if it contains spaces
            if (preg_match('/\s/', $value)) {
                $value = '"' . $value . '"';
            }

            // Check if the key exists (active or commented out)
            $escapedValue = str_replace('\\', '\\\\', $value);

            // Match an active key or a commented out key with or without a space after #
            $pattern = '/^#?\s*' . preg_quote($key, '/') . '=.*/m';

            if (preg_match($pattern, $env)) {
                // Replace the entire matched line with the new active key=value pair
                $env = preg_replace($pattern, $key . '=' . $escapedValue, $env);
            } else {
                // Append the key if not found
                $env .= "\n" . $key . '=' . $value . "\n";
            }

            file_put_contents($path, $env);
        }
    }
}
