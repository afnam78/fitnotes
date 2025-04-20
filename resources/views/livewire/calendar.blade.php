<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div id="calendar">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script type="text/javascript">

        document.addEventListener('livewire:initialized', function() {
            let calendarEl = document.getElementById('calendar');
            let calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                editable: true,
                selectable: true,
                events: [
                    {
                        id: '1',
                        title: 'Pecho',
                        start: '2025-04-19',
                        color: '#FF0000'
                    },
                    {
                        id: '2',
                        title: 'Piernas',
                        start: '2025-04-19'
                    },
                ],
                dateClick: function (event)
                {
                    window.open('https://www.youtube.com/watch?v=2z8JmcrWAs0', '_blank');
                    console.log(event);
                },
                eventClick: function (info)
                {
                    console.log(info.event.id);
                    // redirect youtube url
                },
            });
            calendar.render();



        });


    </script>
@endpush
