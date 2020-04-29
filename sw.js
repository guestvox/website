//variable de los recirsosrecursos que enviaremos a caché
var resourcesToCache = ["index.php"];

//evento install del serviceworker
this.addEventListener("install", function (event) {
  event.waitUntil(
    //Abrimos el caché en este caso le pusimos como nombre "offlineSiteCache"
    caches
      .open("offlineSiteCache")
      .then(function (cache) {
        //si se creo el caché agregamos los archivos al cache pasandole la varible declarada arriba
        return cache.addAll(resourcesToCache);
      })
      .then(function () {
        //si se agrego el cache correntamente omitimos la espera del navegador
        return self.skipWaiting();
      })
      .catch(function () {
        //si hay algun error en el proceso, obtenemos la respuesta con match y los retornamos para decirle al navegador que fallo la instalacion del service worker
        return caches.match(event.request);
      })
  );
});
//El evento fetch se activa cuando estamos fuera de linea.
this.addEventListener("fetch", function (event) {
  //El event.respondWith nos retornará la pagina que este en el caché
  event.respondWith(
    fetch(event.request)
      .catch(function () {
        //si existe el caché lo abrimos y retornamos lo que tenga asignado
        return caches.match(event.request);
      })
      .catch(function () {
        //Si hay un error al hacer esto imprimimos un error
        console.log("Error");
      })
  );
});
