function CalendarComponent(containerId, initialEvents = {}) {
    const calendar = {
        containerId: containerId,
        currentDate: new Date(),
        events: initialEvents,
        renderCalendar: function () {
            const container = document.getElementById(calendar.containerId);
            container.innerHTML = '';

            const calendarDiv = document.createElement('div');
            calendarDiv.className = 'bg-white shadow-lg rounded-lg p-6';

            const headerDiv = document.createElement('div');
            headerDiv.className = 'calendar-header flex justify-center items-center mb-4 rounded-t-md py-2';

            const titleDiv = document.createElement('h2');
            titleDiv.className = 'text-xl font-semibold text-gray-800 text-center';
            const monthNameSpan = document.createElement('span');
            monthNameSpan.id = 'month-name';
            monthNameSpan.className = 'capitalize';
            const yearSpan = document.createElement('span');
            yearSpan.id = 'year';

            titleDiv.appendChild(monthNameSpan);
            titleDiv.appendChild(document.createTextNode(' '));
            titleDiv.appendChild(yearSpan);
            headerDiv.appendChild(titleDiv);
            calendarDiv.appendChild(headerDiv);

            const daysHeaderDiv = document.createElement('div');
            daysHeaderDiv.className = 'grid grid-cols-7 gap-2 mb-2 text-sm';
            daysHeaderDiv.innerHTML = `
                <div class="text-center text-gray-600 font-medium">Do</div>
                <div class="text-center text-gray-600 font-medium">Lu</div>
                <div class="text-center text-gray-600 font-medium">Ma</div>
                <div class="text-center text-gray-600 font-medium">Mi</div>
                <div class="text-center text-gray-600 font-medium">Ju</div>
                <div class="text-center text-gray-600 font-medium">Vi</div>
                <div class="text-center text-gray-600 font-medium">Sa</div>
            `;
            calendarDiv.appendChild(daysHeaderDiv);

            const calendarGridDiv = document.createElement('div');
            calendarGridDiv.id = 'calendar-grid';
            calendarGridDiv.className = 'grid grid-cols-7 gap-2';
            calendarDiv.appendChild(calendarGridDiv);

            const buttonDiv = document.createElement('div');
            buttonDiv.className = 'flex justify-center space-x-2 mt-4';

            const prevButton = document.createElement('button');
            prevButton.id = 'prev-month';
            prevButton.className = 'bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1 px-2 rounded';
            prevButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>`;
            prevButton.addEventListener('click', () => {
                calendar.currentDate.setMonth(calendar.currentDate.getMonth() - 1);
                calendar.renderCalendar();
            });

            const nextButton = document.createElement('button');
            nextButton.id = 'next-month';
            nextButton.className = 'bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1 px-2 rounded';
            nextButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>`;
            nextButton.addEventListener('click', () => {
                calendar.currentDate.setMonth(calendar.currentDate.getMonth() + 1);
                calendar.renderCalendar();
            });

            buttonDiv.appendChild(prevButton);
            buttonDiv.appendChild(nextButton);
            calendarDiv.appendChild(buttonDiv);

            container.appendChild(calendarDiv);

            const calendarGrid = document.getElementById('calendar-grid');
            const monthName = document.getElementById('month-name');
            const yearDisplay = document.getElementById('year');

            const year = calendar.currentDate.getFullYear();
            const month = calendar.currentDate.getMonth();
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
            monthName.textContent = monthNames[month];
            yearDisplay.textContent = year;

            let dayCounter = 1;
            for (let i = 0; i < 6; i++) {
                for (let j = 0; j < 7; j++) {
                    if ((i === 0 && j < firstDay) || dayCounter > daysInMonth) {
                        const emptyCell = document.createElement('div');
                        calendarGrid.appendChild(emptyCell);
                    } else {
                        const dayCell = document.createElement('div');
                        dayCell.classList.add('p-2', 'relative', 'bg-white', 'hover:bg-gray-50', 'transition-colors', 'text-sm');
                        dayCell.textContent = dayCounter;
                        const fullDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(dayCounter).padStart(2, '0')}`;
                        const dayEvents = calendar.events[fullDate] || [];

                        const cellContent = document.createElement('div');
                        cellContent.className = 'flex flex-col';

                        if (dayEvents.length > 0) {
                            const eventsContainer = document.createElement('div');
                            eventsContainer.className = 'mt-1 space-y-1 w-full';
                            dayEvents.forEach(event => {
                                const eventCard = document.createElement('div');
                                eventCard.classList.add('event-card', event.completed ? 'completed' : 'not-completed');
                                const icon = document.createElement('span');
                                icon.className = event.completed ? 'completed-icon' : 'not-completed-icon';
                                icon.innerHTML = event.completed
                                    ? `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm3.857-9.808a.75.75 0 0 0-1.08 1.04L9.04 12.801a.75.75 0 0 0 1.08 1.04l4.321-5.192a.75.75 0 0 0 0-1.08z" clip-rule="evenodd" />
                                        </svg>`
                                    : `!`;
                                eventCard.appendChild(icon);
                                eventCard.appendChild(document.createTextNode(event.title));
                                eventsContainer.appendChild(eventCard);
                            });
                            cellContent.appendChild(eventsContainer);
                        }
                        dayCell.appendChild(cellContent);
                        calendarGrid.appendChild(dayCell);
                        dayCounter++;
                    }
                }
                if (dayCounter > daysInMonth) break;
            }
        }
    };

    calendar.containerId = containerId;
    calendar.events = initialEvents;
    calendar.renderCalendar();
    return calendar;
}