
function navigateTo(url) {
    console.log("非同期遷移開始:", url);
    fetch(url, { headers: { "X-Requested-With": "XMLHttpRequest" } })
        .then(res => res.text())
        .then(html => {
            document.querySelector("main.main-container").innerHTML = html;
            history.pushState({}, "", url);
        })
        .catch(err => console.error(err));
}

document.querySelectorAll('.menu a').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();
        const url = this.getAttribute('href');
        navigateTo(url);
    });
});


