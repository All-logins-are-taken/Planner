addEventListener("load", clipImageInPolygon(document.getElementById("img-0")));

function importProjects() {
    let action = 'import';
    let messageBox = document.getElementById("message")
    let button = document.getElementById("import_button");
    messageBox.innerText = "";
    button.innerText = 'Importing ...';
    button.disabled = true;

    const request = new XMLHttpRequest();
    const url = "/";
    const params = "action=" + action;

    request.open("POST", url);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    request.addEventListener("readystatechange", () => {
        button.innerText = 'Import projects';
        button.disabled = false;

        if(request.readyState === 4 && request.status === 200) {
            messageBox.innerText = request.responseText;
            messageBox.setAttribute("class", "alert alert-success");
            window.location.reload();
        }
        else {
            messageBox.setAttribute("class", "alert alert-danger");
            messageBox.innerText  = "Server error";
        }
    });

    request.send(params);
}

function clipImageInPolygon(img) {
    let canvas = document.getElementById('canvas');
    let ctx = canvas.getContext('2d');
    ctx.drawImage(img, 0, 0, 200, 200);
}