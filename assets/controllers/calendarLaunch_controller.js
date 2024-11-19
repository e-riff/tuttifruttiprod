import {Controller} from '@hotwired/stimulus';
import {Calendar} from '@fullcalendar/core';
import ListPlugin from '@fullcalendar/list';

export default class extends Controller {

    connect() {
        const calendar = new Calendar(this.element, {
            plugins: [ListPlugin],
            initialView: 'listYear',
            events: [
                {
                    title: 'Meeting',
                    start: '2024-08-12T14:30:00',
                    extendedProps: {
                        status: 'done'
                    }
                },
                {
                    title: 'Birthday Party',
                    start: '2024-08-13T07:00:00',
                    backgroundColor: 'green',
                    borderColor: 'green'
                }
            ],

        });
        calendar.render();
    }
}
