window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */


import Echo from 'laravel-echo';
import axios from 'axios';
import $ from 'jquery';

window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host       : window.location.hostname + ':6001'
});

window.Echo.channel('messages')
    .listen('MessageSend', (e) => {
        console.log('receive MSG', e);
    });

window.onClickSendMessage = function() {
    const body = document.querySelector('input[name=body]').value;
    console.log(body);
    axios.post('/chat/send', {
        body
    })
        .then(function (response) {
            console.log('send OK', response);
        })
        .catch(function (error) {
            console.log('send Fail', error);
        });
};


function render(messages)
{
    const messageBox = document.querySelector("#message-box");
    messageBox.innerHTML = '';

    const root = document.createElement("div");

    messages.forEach((msg) => {
        const p = document.createElement("p");
        const content = document.createTextNode(msg);
        p.appendChild(content);
        root.appendChild(p);
    });

    messageBox.appendChild(root);
}

function updateMessageBox()
{
    axios.get('/chat/list')
        .then(function (response) {
            render(response.data);
            console.log('send OK', response);

        })
        .catch(function (error) {
            console.log('send Fail', error);
        });
}

$(() => {
    updateMessageBox();
});
