import "./bootstrap";

import toastr from 'toastr';
window.toastr = toastr;

toastr.options = {
    closeButton: false,
    debug: false,
    newestOnTop: true,
    progressBar: true,
    positionClass: 'toast-top-right',
    preventDuplicates: false,
    onclick: null,
    showDuration: '300',
    hideDuration: '1000',
    timeOut: '5000',
    extendedTimeOut: '1000',
    showEasing: 'swing',
    hideEasing: 'linear',
    showMethod: 'fadeIn',
    hideMethod: 'fadeOut',
};

async function toastrToast({ type, title, text }) {
    await toastr[type](text, title);
}

window.toastrToast = toastrToast;

document.addEventListener('toast', (event) => {
    toastrToast(event.detail[0]);
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("input").forEach((input) => {
        input.addEventListener("focus", () => {
            if (input.classList.contains("input-error")) {
                input.classList.remove("input-error");
            }

            let parent = input.parentElement;
            let error = parent.querySelector(".text-error");
            if (error) {
                error.remove();
            }
        });
    });
});

import {livewire_hot_reload} from 'virtual:livewire-hot-reload'

livewire_hot_reload();