const CACHE_NAME = "brif-pwa-v3";

const STATIC_ASSETS = [
    "/manifest.json",
    "/images/icon-192.png",
    "/images/icon-512.png",
];

self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll(STATIC_ASSETS)),
    );
    self.skipWaiting();
});

self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((keys) =>
            Promise.all(
                keys.map((key) => {
                    if (key !== CACHE_NAME) {
                        return caches.delete(key);
                    }
                }),
            ),
        ),
    );
    self.clients.claim();
});

self.addEventListener("fetch", (event) => {
    const request = event.request;

    if (request.method !== "GET") return;

    const acceptHeader = request.headers.get("accept") || "";
    const url = new URL(request.url);

    // HTML 页面永远走网络，不走 cache
    if (acceptHeader.includes("text/html")) {
        event.respondWith(fetch(request).catch(() => caches.match(request)));
        return;
    }

    // 只缓存同域静态资源
    if (
        url.origin === location.origin &&
        (url.pathname.startsWith("/build/") ||
            url.pathname.startsWith("/images/") ||
            url.pathname.endsWith(".css") ||
            url.pathname.endsWith(".js") ||
            url.pathname.endsWith(".png") ||
            url.pathname.endsWith(".jpg") ||
            url.pathname.endsWith(".jpeg") ||
            url.pathname.endsWith(".svg") ||
            url.pathname.endsWith(".webp") ||
            url.pathname.endsWith(".woff") ||
            url.pathname.endsWith(".woff2"))
    ) {
        event.respondWith(
            caches.match(request).then((cached) => {
                return (
                    cached ||
                    fetch(request).then((response) => {
                        const responseClone = response.clone();
                        caches
                            .open(CACHE_NAME)
                            .then((cache) => cache.put(request, responseClone));
                        return response;
                    })
                );
            }),
        );
    }
});
