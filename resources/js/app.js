import './bootstrap';
import '../css/app.css';

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import {
    faArrowRight,
    faArrowUpRightFromSquare,
    faBars,
    faCheck,
    faChevronDown,
    faCircleCheck,
    faEnvelope,
    faGaugeHigh,
    faGear,
    faHouse,
    faKey,
    faLayerGroup,
    faLock,
    faRightFromBracket,
    faRightToBracket,
    faShieldHalved,
    faUser,
    faUserPlus,
    faXmark,
} from '@fortawesome/free-solid-svg-icons';

import App from './App.vue';
import router from './router';

library.add(
    faArrowRight,
    faArrowUpRightFromSquare,
    faBars,
    faCheck,
    faChevronDown,
    faCircleCheck,
    faEnvelope,
    faGaugeHigh,
    faGear,
    faHouse,
    faKey,
    faLayerGroup,
    faLock,
    faRightFromBracket,
    faRightToBracket,
    faShieldHalved,
    faUser,
    faUserPlus,
    faXmark,
);

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.component('FontAwesomeIcon', FontAwesomeIcon);

app.mount('#app');
