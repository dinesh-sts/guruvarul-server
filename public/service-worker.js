// service-worker.js

const CACHE_NAME = "guruvarul-cache-v1";
const urlsToCache = [
  "/",             // homepage
  "/manifest.json",
  "/icons/favicon.png",
  "/icons/favicon.png",
  // add CSS/JS files if needed, e.g.:
  // "/css/app.css",
  // "/js/app.js"
];

// Install Service Worker & Cache Assets
self.addEventListener("install", event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      return cache.addAll(urlsToCache);
    })
  );
});

// Serve from Cache, fallback to Network
self.addEventListener("fetch", event => {
  event.respondWith(
    caches.match(event.request).then(response => {
      return response || fetch(event.request);
    })
  );
});

// Activate and clean old caches
self.addEventListener("activate", event => {
  event.waitUntil(
    caches.keys().then(keys => {
      return Promise.all(
        keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))
      );
    })
  );
});
