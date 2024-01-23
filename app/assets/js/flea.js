let elements = document.getElementsByClassName("flea-bite");

for (let i = 0; i < elements.length; i++) {
    elements[i].addEventListener('click', function (event) {
        console.log(event.currentTarget.id);
    });
}