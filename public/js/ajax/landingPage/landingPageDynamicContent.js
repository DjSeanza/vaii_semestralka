let offset = 8;
let timeout;

window.addEventListener("scroll", function() {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            let xhr = new XMLHttpRequest();
            xhr.onload = function() {
                if (xhr.status === 200) {
                    offset += 8;
                    let videos = JSON.parse(xhr.responseText);
                    videos.forEach(video => {
                        createVideoContainer(video.video.id, video.video.title, video.author, video.video.author, video.video.views, video.video.thumbnail, "div#generated-videos");
                    })
                }
            };

            xhr.open("POST", "http://localhost/vaii-semestralka/?c=home&a=generateContent", true);
            xhr.setRequestHeader("X-Requested-With", "xmlhttprequest");
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('offset=' + offset);
        }, 500);
    }
});