<?php

declare(strict_types=1);

namespace App\Modules\Shared\Presentation\Livewire;

use App\Modules\Shared\Application\Commands\GetDashboardKPICommand;
use App\Modules\Shared\Application\UseCases\GetDashboardKPIUseCase;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

final class Dashboard extends Component
{
    use Toastable;
    public array $motivationalMessage;
    public int $workoutsToday = 0;
    public int $setsCurrentWeek = 0;

    public float $weeklyVolume = 0.0;

    public function render()
    {
        return view('shared::livewire.dashboard');
    }

    public function mount(GetDashboardKPIUseCase $useCase): void
    {
        $this->motivationalMessage = $this->motivationalMessages()[array_rand($this->motivationalMessages())];

        $command = new GetDashboardKPICommand(auth()->id());
        $result = $useCase->handle($command);

        $this->workoutsToday = $result->workoutsToday;
        $this->setsCurrentWeek = $result->currentWeekSets;
        $this->weeklyVolume = $result->weeklyVolume;
    }

    public function motivationalMessages(): array
    {
        return [
            [
                "sentence" => "La fuerza no viene de la capacidad física, sino de una voluntad indomable.",
                "author" => "Mahatma Gandhi"
            ],
            [
                "sentence" => "La diferencia entre lo imposible y lo posible reside en la determinación de una persona.",
                "author" => "Tommy Lasorda"
            ],
            [
                "sentence" => "El éxito no es definitivo, el fracaso no es fatal: es el coraje para continuar lo que cuenta.",
                "author" => "Winston Churchill"
            ],
            [
                "sentence" => "El dolor es temporal. El abandono es para siempre.",
                "author" => "Lance Armstrong"
            ],
            [
                "sentence" => "La única forma de hacer un gran trabajo es amar lo que haces.",
                "author" => "Steve Jobs"
            ],

            [
                "sentence" => "El camino hacia el éxito y el camino hacia el fracaso son casi exactamente los mismos.",
                "author" => "Colin R. Davis"
            ],
            [
                "sentence" => "La fuerza no viene de ganar. Tus luchas desarrollan tus fortalezas. Cuando pasas por dificultades y decides no rendirte, eso es la fuerza.",
                "author" => "Arnold Schwarzenegger"
            ],
            [
                "sentence" => "La disciplina es el puente entre las metas y los logros.",
                "author" => "Jim Rohn"
            ],

        ];
    }
}
