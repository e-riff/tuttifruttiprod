import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        url: String
    }

    redirect(event) {
        if (event.target.closest('a')) {
            return;
        }

        if (false === this.hasUrlValue || ! this.urlValue) {
            console.error('clickable-article: URL non définie ou vide');
            return;
        }

        window.location.href = this.urlValue;
    }
}
