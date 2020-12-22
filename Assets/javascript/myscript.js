const w = window.innerWidth;
console.log(w);

function openNav(){         
        document.getElementById('mySidenav').style.width = "42%";
        document.getElementById('mySidenav').style.display = "block";
       
}



function closeNav(){
    document.getElementById('mySidenav').style.width = "0";
}

document.getElementById("open-nav").addEventListener("click", openNav);

document.getElementById("close-button").addEventListener("click", closeNav);

document.getElementById("passion-link").addEventListener("click", closeNav);

document.getElementById("food-link").addEventListener("click", closeNav);