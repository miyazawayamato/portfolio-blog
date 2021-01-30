"use strict"


const view = document.getElementById('image-view');
const sel = document.getElementById('image-select');

sel.addEventListener('change', () => {
    const reader = new FileReader();
    reader.onload = function () {
        view.setAttribute('src', reader.result);
    }
    reader.readAsDataURL(sel.files[0]);
})


//画像編集

const oImage = document.getElementById('old-image');
const newImage = document.getElementById('new-image');
const dImage = document.getElementById('delete-image');

const btn = document.getElementsByClassName('btn');
const val = document.getElementById('case');
const img = document.getElementsByClassName('btn-image');



for (let i = 0; i < 3; i++ ) {
    btn[i].addEventListener('click', () => {
        for (let n = 0; n < 3; n++ ) {
            btn[n].classList.remove('red');
            img[n].classList.remove('visible');
        }
        btn[i].classList.add('red');
        img[i].classList.add('visible');
        
        val.value = i;
    })
}


