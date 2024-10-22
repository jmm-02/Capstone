const CACHE_NAME = "app-cache-v1";
const STATIC_CACHE_URLS = [
  "login.php",
  "registration.php",
  "forgot_pass.php",
  "offline.html",
  "output.css",
  "node_modules/@tabler/icons-webfont/dist/tabler-icons.min.css",
  "node_modules/flowbite/dist/flowbite.min.css",
  "node_modules/flowbite/dist/flowbite.min.js",
  "node_modules/select2/dist/js/select2.min.js",
  "node_modules/jquery/dist/jquery.min.js",
  "assets/css/styles.min.css",
];

// Install Service Worker and Cache Static Assets
self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => cache.addAll(STATIC_CACHE_URLS))
      .catch((error) => console.error("Install Error: Failed to cache static assets:", error))
  );
});

// Fetch Event Handler
self.addEventListener("fetch", (event) => {
  const { request } = event;
  const requestURL = new URL(request.url);

  // Dynamic content: Network-first strategy for PHP pages
  if (requestURL.pathname.endsWith(".php")) {
    event.respondWith(networkFirst(request));
  } 
  // Static resources: Stale-while-revalidate strategy
  else if (STATIC_CACHE_URLS.includes(requestURL.pathname)) {
    event.respondWith(staleWhileRevalidate(request));
  } 
  // General fallback strategy for other content
  else {
    event.respondWith(fallbackStrategy(request));
  }
});

// Network First Strategy (for dynamic content)
async function networkFirst(request) {
  try {
    const networkResponse = await fetch(request);
    const cache = await caches.open(CACHE_NAME);
    cache.put(request, networkResponse.clone());
    return networkResponse;
  } catch (error) {
    console.error(`Network First Error: Fetch failed for ${request.url}. Falling back to cache.`, error);
    const cachedResponse = await caches.match(request);
    return cachedResponse || caches.match("offline.html");
  }
}

// Stale-While-Revalidate Strategy (for static resources)
async function staleWhileRevalidate(request) {
  const cache = await caches.open(CACHE_NAME);
  const cachedResponse = await caches.match(request);

  const networkFetch = fetch(request).then((networkResponse) => {
    cache.put(request, networkResponse.clone());
    return networkResponse;
  }).catch((error) => {
    console.error(`Stale-While-Revalidate Error: Fetch failed for ${request.url}.`, error);
  });

  // Serve cached response if available, or wait for network
  return cachedResponse || networkFetch;
}

// Fallback Strategy (for general requests)
async function fallbackStrategy(request) {
  const cachedResponse = await caches.match(request);
  try {
    return cachedResponse || await fetch(request);
  } catch (error) {
    console.error(`Fallback Strategy Error: ${request.url} failed.`, error);
    // Fallback to offline page or placeholder for specific content types
    if (request.headers.get("accept").includes("text/html")) {
      return caches.match("offline.html");
    } else if (request.headers.get("accept").includes("image")) {
      // Optional: Add a placeholder image for failed image fetches
      return new Response(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><rect width="512" height="512" fill="#EEE"/><text x="50%" y="50%" fill="#999" font-size="48" text-anchor="middle" dy=".3em">Image Offline</text></svg>', 
        { headers: { "Content-Type": "image/svg+xml" } }
      );
    } else {
      return new Response("Service unavailable.", { status: 503, statusText: "Service Unavailable" });
    }
  }
}

// Activate Service Worker and Clean Up Old Caches
self.addEventListener("activate", (event) => {
  const cacheWhitelist = [CACHE_NAME];
  event.waitUntil(
    caches.keys()
      .then((cacheNames) => Promise.all(
        cacheNames.map((cacheName) => {
          if (!cacheWhitelist.includes(cacheName)) {
            console.log(`Deleting old cache: ${cacheName}`);
            return caches.delete(cacheName);
          }
        })
      ))
      .catch((error) => console.error("Activate Error: Cache cleanup failed.", error))
  );
});

// --------------------------------------


