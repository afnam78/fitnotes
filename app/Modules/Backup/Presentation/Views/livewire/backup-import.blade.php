<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">
                Backup
            </h2>
        </div>
    </x-slot>
    <div class="flex justify-center items-center ">
        <div class="space-y-2 max-w-lg">
            <div class="bg-red-200 border-2 border-red-600 rounded-md p-4 font-bold text-red-600">
                <p>
                    Al importar, perderás todos los datos actuales.
                </p>
                <p>
                    Asegúrate de que el archivo es correcto.
                </p>
            </div>
            <div class="border rounded-lg p-4 w-full">
                <form wire:submit="import" class="space-y-2">
                    <div>
                        <input type="file" wire:model="file" accept="application/json" class="block sm:max-w-lg border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none
    file:bg-gray-50 file:border-0
    file:me-4
   ">
                    </div>
                    <div class="flex justify-end">
                        <x-primary-button>Importar</x-primary-button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
