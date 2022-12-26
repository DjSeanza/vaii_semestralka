// TODO pridat onclick ak je na related videos + pridat class ak je na related videos

function createVideoContainer(idPar, titlePar, authorPar, authorIntPar, viewsPar, thumbnailPar, mainContainer) {
    let allVideosContainer = document.querySelector(mainContainer);
    const article = document.createElement('article');
    article.classList.add('video-article-container');
    if (mainContainer === 'div.related-videos') {
        article.classList.add('related-videos-video-container');
        article.onclick = function () {
            location.href='?c=content&a=content&v=' + idPar;
        }
    }
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
    author.href = '?c=content&a=listContent&uid=' + authorIntPar;
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