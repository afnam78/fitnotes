<div class="flex justify-center items-center">
    <div class="border rounded-lg p-4 w-fit">
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
