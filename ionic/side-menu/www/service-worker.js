
self.addEventListener('activate', function (event) {
	console.log('activate');
});

self.addEventListener('fetch', function (event) {
	console.log('fetch');
});

self.addEventListener('push', function (event) {
	console.log('push');
});