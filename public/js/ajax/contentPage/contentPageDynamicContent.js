let offset = 5;
let timeout;

window.addEventListener("scroll", function() {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            let xhr = new XMLHttpRequest();
            xhr.onload = function() {
                if (xhr.status === 200) {
                    if (xhr.responseText == null) {
                        return;
                    }

                    offset += 5;
                    let videos = JSON.parse(xhr.responseText);
                    videos.forEach(video => {
                        createVideoContainer(video.video.id, video.video.title, video.author, video.video.author, video.video.views, video.video.thumbnail, "div.related-videos");
                    })
                }
            };

            xhr.open("POST", "http://localhost/vaii-semestralka/?c=content&a=getNotAuthorVideos", true);
            xhr.setRequestHeader("X-Requested-With", "xmlhttprequest");
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('offset=' + offset + "&v=" + new URLSearchParams(window.location.search).get("v"));
        }, 500);
    }
});