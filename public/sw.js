const CACHE_NAME = "brif-pwa-v2";

const urlsToCache = [
    "/manifest.json",
    "/images/icon-192.png",
    "/images/icon-512.png",
];

self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll(urlsToCache)),
    );
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

    if (request.method !== "GET") {
        return;
    }

    const url = new URL(request.url);

    // 不要缓存 HTML 页面 / 登录相关页面
    if (request.headers.get("accept")?.includes("text/html")) {
        event.respondWith(fetch(request));
        return;
    }

    // 静态资源才走 cache
    event.respondWith(
        caches.match(request).then((response) => response || fetch(request)),
    );
});
