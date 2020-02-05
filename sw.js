var resourcesToCache = [
    "index.php"
];

this.addEventListener("install", function (event) {
    //console.log("Instalando Service Worker");
    event.waitUntil(
            caches
            .open("offlineSiteCache")
            .then(function (cache) {
                return cache.addAll(resourcesToCache);
            })
            .then(function () {
                return self.skipWaiting();
            })
            .catch(function () {
                return caches.match(event.request);
            })
            );
});

this.addEventListener("fetch", function (event) {
    event.respondWith(
            fetch(event.request).catch(function () {
        return caches.match(event.request);
    }).catch(function () {
        console.log("Error en el fetch :( ");
    })
            );
});
this.addEventListener('activate', event => {
    //console.log('V1 now ready to handle fetches!');
});