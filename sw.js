/**
 * Sugar Cafe by Georgia - Service Worker
 * Handles caching for offline support and PWA functionality
 */

const CACHE_NAME = 'sugar-cafe-v2';
const STATIC_CACHE = 'sugar-cafe-static-v2';
const DYNAMIC_CACHE = 'sugar-cafe-dynamic-v2';

// Static assets to cache on install
const STATIC_ASSETS = [
    '/sugar-cafe/',
    '/sugar-cafe/index.php',
    '/sugar-cafe/menu.php',
    '/sugar-cafe/about.php',
    '/sugar-cafe/contact.php',
    '/sugar-cafe/assets/css/sugar-cafe.css',
    '/sugar-cafe/manifest.json',
    '/sugar-cafe/offline.html'
];

// Install event - cache static assets
self.addEventListener('install', (event) => {
    console.log('[SugarCafe SW] Installing...');
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then((cache) => {
                console.log('[SugarCafe SW] Caching static assets');
                return cache.addAll(STATIC_ASSETS).catch(err => {
                    console.log('[SugarCafe SW] Some assets failed to cache:', err);
                });
            })
    );
    self.skipWaiting();
});

// Activate event - clean up old caches
self.addEventListener('activate', (event) => {
    console.log('[SugarCafe SW] Activating...');
    event.waitUntil(
        caches.keys()
            .then((keyList) => {
                return Promise.all(keyList.map((key) => {
                    if (key !== STATIC_CACHE && key !== DYNAMIC_CACHE) {
                        console.log('[SugarCafe SW] Removing old cache:', key);
                        return caches.delete(key);
                    }
                }));
            })
    );
    self.clients.claim();
});

// Fetch event - serve from cache or network
self.addEventListener('fetch', (event) => {
    // Skip non-GET requests
    if (event.request.method !== 'GET') return;
    
    // Skip API calls
    if (event.request.url.includes('/api/')) return;
    
    // Skip external requests
    if (!event.request.url.startsWith(self.location.origin)) return;

    event.respondWith(
        caches.match(event.request)
            .then((cachedResponse) => {
                if (cachedResponse) {
                    // Return cached version and update cache in background
                    event.waitUntil(
                        fetch(event.request)
                            .then((networkResponse) => {
                                if (networkResponse && networkResponse.status === 200) {
                                    caches.open(DYNAMIC_CACHE)
                                        .then((cache) => {
                                            cache.put(event.request, networkResponse.clone());
                                        });
                                }
                            })
                            .catch(() => {})
                    );
                    return cachedResponse;
                }
                
                // Not in cache - fetch from network
                return fetch(event.request)
                    .then((networkResponse) => {
                        if (!networkResponse || networkResponse.status !== 200) {
                            return networkResponse;
                        }
                        
                        // Cache the new response
                        const responseClone = networkResponse.clone();
                        caches.open(DYNAMIC_CACHE)
                            .then((cache) => {
                                cache.put(event.request, responseClone);
                            });
                        
                        return networkResponse;
                    })
                    .catch(() => {
                        // Offline fallback
                        if (event.request.destination === 'document') {
                            return caches.match('/sugar-cafe/offline.html');
                        }
                    });
            })
    );
});

// Background Sync for offline orders
self.addEventListener('sync', (event) => {
    console.log('[SugarCafe SW] Background sync:', event.tag);
    if (event.tag === 'sync-orders') {
        event.waitUntil(syncPendingOrders());
    }
});

// Push notifications
self.addEventListener('push', (event) => {
    const options = {
        body: event.data ? event.data.text() : 'New updates from Sugar Cafe!',
        icon: '/assets/images/icons/icon-192x192.png',
        badge: '/assets/images/icons/icon-72x72.png',
        vibrate: [100, 50, 100],
        data: {
            url: '/sugar-cafe/'
        },
        actions: [
            { action: 'view', title: 'View' },
            { action: 'dismiss', title: 'Dismiss' }
        ]
    };
    
    event.waitUntil(
        self.registration.showNotification('Sugar Cafe by Georgia', options)
    );
});

// Handle notification click
self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    
    if (event.action === 'view' || !event.action) {
        event.waitUntil(
            clients.openWindow(event.notification.data.url || '/sugar-cafe/')
        );
    }
});

// Sync pending orders function
async function syncPendingOrders() {
    // This would sync any orders made while offline
    console.log('[SugarCafe SW] Syncing pending orders...');
}
