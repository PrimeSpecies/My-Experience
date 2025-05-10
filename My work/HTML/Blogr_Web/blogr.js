function buttonclick(){
    let menu = document.querySelector(".sidebar");
    let currentDisplay = window.getComputedStyle(menu).display;
    if (menu.style.display === "none"){
        menu.style.display = "block";
    }else{
        menu.style.display = "none";
    }
}