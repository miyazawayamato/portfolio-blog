"use strict"

const btn = document.getElementsByClassName('delete-btn');
const exe = document.getElementsByClassName('delete-exe');

for (let i = 0; i < btn.length; i++) {
    btn[i].addEventListener('click', () => {
        if (confirm("削除しますか")) {
            location.href = exe[i].href;
        }
    })
}