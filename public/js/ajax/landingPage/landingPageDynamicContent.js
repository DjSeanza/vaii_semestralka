let offset = 8;
let timeout;

window.addEventListener("scroll", function() {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            let xhr = new XMLHttpRequest();
            xhr.onloadend = function() {
                if (xhr.status === 200) {
                    offset += 8;
                    let videos = JSON.parse(xhr.responseText);
                    videos.forEach(video => {
                        createVideoContainer(video.video.id, video.video.title, video.author, video.video.views, video.video.thumbnail);
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

function createVideoContainer(idPar, titlePar, authorPar, viewsPar, thumbnailPar) {
    let allVideosContainer = document.querySelector("div#generated-videos");
    const article = document.createElement('article');
    article.classList.add('video-article-container');
    article.setAttribute('onclick', "location.href='?c=content&a=content&v='" + idPar);

    const thumbnail = document.createElement('div');
    thumbnail.classList.add('video-thumbnail');

    const img = document.createElement('img');
    img.src = thumbnailPar;
    img.alt = '';

    thumbnail.appendChild(img);
    article.appendChild(thumbnail);

    const details = document.createElement('div');
    details.classList.add('video-article-details');

    const title = document.createElement('h3');
    title.classList.add('video-article-title');
    title.textContent = titlePar;

    const author = document.createElement('a');
    author.classList.add('video-article-author');
    // TODO dat href ked dam aj autorov
    author.href = '#';
    author.textContent = authorPar;

    const views = document.createElement('span');
    views.classList.add('video-article-views');
    views.textContent = viewsPar + ' zhliadnutí';

    details.appendChild(title);
    details.appendChild(author);
    details.appendChild(views);
    article.appendChild(details);

    allVideosContainer.appendChild(article);
}