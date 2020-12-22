const editBtn = document.querySelector('.food-img span');
const fileBox = document.getElementById("fileBox");
editBtn.addEventListener("click", (evt)=>{
    fileBox.classList.remove('d-none');
});
const cancelbtn = fileBox.querySelector('.control button[type=button]');

cancelbtn.addEventListener('click', (evt)=>{
    fileBox.classList.add('d-none');
})