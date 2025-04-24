import {Controller} from '@hotwired/stimulus';
import {Calendar} from '@fullcalendar/core';
import listPlugin from '@fullcalendar/list';
import bootstrap5Plugin from '@fullcalendar/bootstrap5';
import allLocales from '@fullcalendar/core/locales-all';

export default class extends Controller {
    connect()
    {
        const calendar = new Calendar(this.element, {
            plugins: [
                listPlugin,
                bootstrap5Plugin
            ],
            initialView: 'listYear',
            themeSystem: 'bootstrap5',
            locales: allLocales,
            locale: 'fr',
            events: '/concerts/confirmed',
            eventContent: function (arg) {
                let url = arg.event.extendedProps.url;
                let bandName = arg.event.title;
                return {
                    html: `<a href="${url}" target="_blank">
                          ${bandName}
                        </a>`
                };
            },
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'listYear'
            },
        });
        calendar.render();
    }
}
