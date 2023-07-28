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

// Gestion des tabs
// create an array of objects with the id, trigger element (eg. button), and the content element
const tabElements = [
    {
        id: 'profile',
        triggerEl: document.querySelector('#profile-tab-example'),
        targetEl: document.querySelector('#profile-example')
    },
    {
        id: 'dashboard',
        triggerEl: document.querySelector('#dashboard-tab-example'),
        targetEl: document.querySelector('#dashboard-example')
    },
    {
        id: 'settings',
        triggerEl: document.querySelector('#settings-tab-example'),
        targetEl: document.querySelector('#settings-example')
    },
    {
        id: 'contacts',
        triggerEl: document.querySelector('#contacts-tab-example'),
        targetEl: document.querySelector('#contacts-example')
    }
];

// options with default values
const options= {
    defaultTabId: 'settings',
    activeClasses: 'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-400 border-blue-600 dark:border-blue-500',
    inactiveClasses: 'text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300',
    onShow: () => {
        console.log('tab is shown');
    }
};

/*
* tabElements: array of tab objects
* options: optional
*/
const tabs = new Tabs(tabElements, options);

// open tab item based on id
tabs.show('contacts');