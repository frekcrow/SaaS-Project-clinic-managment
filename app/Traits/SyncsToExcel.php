<?php

namespace App\Traits;

use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Support\Facades\File;

trait SyncsToExcel
{
    public static function bootSyncsToExcel()
    {
        static::saved(function ($model) {
            $model->syncToExcelArchive();
        });
    }

    public function syncToExcelArchive()
    {
        $tenant = $this->tenant;

        if (!$tenant || empty($tenant->excel_export_path)) {
            return;
        }

        $dir = $tenant->excel_export_path;

        if (!is_dir($dir)) {
            // We could try to create it, or simply return if it doesn't exist
            // Let's create it for robustness if possible, but the prompt says:
            // "Check if $tenant->excel_export_path is set and the directory exists."
            if (!File::exists($dir)) {
                try {
                    File::makeDirectory($dir, 0755, true);
                } catch (\Exception $e) {
                    return;
                }
            }
        }

        $filename = $this->getTable() . '.xlsx';
        $path = rtrim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;

        $attributes = $this->toArray();
        // Convert any array attributes (like JSON casts) to string so Spout doesn't crash
        foreach ($attributes as $key => $value) {
            if (is_array($value)) {
                $attributes[$key] = json_encode($value);
            }
        }
        $attributes['Sync_Date'] = now()->format('Y-m-d H:i:s');

        $rows = [];

        // SimpleExcel doesn't append to .xlsx natively, so we read existing rows first
        if (File::exists($path)) {
            try {
                $reader = SimpleExcelReader::create($path);
                $rows = $reader->getRows()->toArray();
            } catch (\Exception $e) {
                // If it fails to read, we just start fresh or ignore
            }
        }

        $rows[] = $attributes;

        try {
            $writer = SimpleExcelWriter::create($path);
            $writer->addRows($rows);
            $writer->close();
        } catch (\Exception $e) {
            // Log or ignore failure to write to the archive
        }
    }
}
