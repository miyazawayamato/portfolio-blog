const select = document.getElementById('select');
const selnum = document.getElementById('select-num');

const num = selnum.textContent - 1;

select.options[num].selected = true