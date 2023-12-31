/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';
import a2lix_lib from '@a2lix/symfony-collection/dist/a2lix_sf_collection.min'
a2lix_lib.sfCollection.init()

import {
    Tab,
    initTE,
} from "tw-elements";

initTE({ Tab });
// Gestion des badges
const spans = document.querySelectorAll('.badge');

for (const span of spans) {
    const classes = ['badge-blue', 'badge-red', 'badge-green', 'badge-yellow', 'badge-indigo', 'badge-purple', 'badge-pink'];
    const randomClass = classes[Math.floor(Math.random() * classes.length)];
    span.classList.add(randomClass);
}

// Gestion des messages flash
setTimeout(function () {
    $("#flash-messages").remove();
}, 5000);