function toastError(title, text) {
    let toast = document.querySelector("div.toast");
    let toastTitle = document.querySelector("div.toast h3");
    let toastText = document.querySelector("div.toast p");
    toastTitle.innerHTML = title;
    toastText.innerHTML = text;
    toast.classList.add("show");
    toast.classList.add("error");
    setTimeout(function() {
        toast.classList.remove("show");
        toast.classList.remove("error");
    }, 3000);
}

function toastSuccess(title, text) {
    let toast = document.querySelector("div.toast");
    let toastTitle = document.querySelector("div.toast h3");
    let toastText = document.querySelector("div.toast p");
    toastTitle.innerHTML = title;
    toastText.innerHTML = text;
    toast.classList.add("show");
    toast.classList.add("success");
    setTimeout(function() {
        toast.classList.remove("show");
        toast.classList.remove("success");
    }, 3000);
}