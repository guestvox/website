var resourcesToCache = [
    'index.php'
];

this.addEventListener('install', function(event) {
    event.waitUntil(
        caches
        .open('offlineSiteCache')
        .then(function(cache) {
            return cache.addAll(resourcesToCache);
        })
        .then(function() {
            return self.skipWaiting();
        })
        .catch(function() {
            return caches.match(event.request);
        })
    );
});

this.addEventListener('fetch', function(event) {
    event.respondWith(
        fetch(event.request).catch(function() {
            return caches.match(event.request);
        }).catch(function() {
            console.log('Error');
        })
    );
});

this.addEventListener('activate', event => {

});
