<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class BackendController extends Controller
{
    
    public function backend_index(): View
    {  
        return view('backend/pages/index');
    }

    // BackupController.php
    public function export()
    {
        $filename = 'Meli\'Glow_backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
        $path = storage_path('backups/' . $filename);

        if (!file_exists(storage_path('backups'))) {
            mkdir(storage_path('backups'), 0755, true);
        }

        $host     = config('database.connections.mysql.host');
        $port     = config('database.connections.mysql.port');
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        $passwordPart = !empty($password) ? "--password='{$password}'" : "";

        $dumpBin = app()->environment('production') ? '/usr/bin/mariadb-dump' : 'C:\\xampp\\mysql\\bin\\mysqldump.exe';

        $command = "\"{$dumpBin}\" --user={$username} {$passwordPart} --host={$host} --port={$port} {$database} > \"{$path}\" 2>&1";

        system($command, $resultCode);

        if ($resultCode !== 0 || !file_exists($path) || filesize($path) === 0) {
            return redirect()->back()->with('error', "❌ Échec de l'export de la base de données.");
        }

        return response()->download($path, $filename)->deleteFileAfterSend(true);
    }

}
