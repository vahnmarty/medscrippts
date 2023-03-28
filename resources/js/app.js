import './bootstrap';

import Splide from '@splidejs/splide';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import FormsAlpinePlugin from '../../vendor/filament/forms/dist/module.esm'
import NotificationsAlpinePlugin from '../../vendor/filament/notifications/dist/module.esm'

window.Alpine = Alpine;
Alpine.plugin(FormsAlpinePlugin)
Alpine.plugin(NotificationsAlpinePlugin)

Alpine.plugin(focus);

Alpine.start();


new Splide( '.splide', { 
    perPage: 1,
  focus  : 'center',
} ).mount();