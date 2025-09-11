<?php

declare(strict_types=1);

namespace App\Modules\Backup\Presentation\Livewire;

use App\Modules\Backup\Application\Commands\LoadBackupCommand;
use App\Modules\Backup\Application\UseCases\LoadBackupUseCase;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toastable;

final class BackupImport extends Component
{
    use Toastable;
    use WithFileUploads;
    public $file;

    public function render()
    {
        return view('backup::livewire.backup-import');
    }

    public function import(LoadBackupUseCase $useCase): void
    {
        $this->validate([
            'file' => 'required|mimes:json',
        ]);

        try {
            $command = new LoadBackupCommand($this->file->getRealPath(), auth()->id());

            $useCase->handle($command);

            $this->success('Se ha iniciado la importación del archivo. Esto puede tardar unos minutos.');
        } catch (Exception $e) {
            $this->error('Error al importar el archivo');
        }
    }
}
