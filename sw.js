console.log('Started', self);


self.addEventListener('install', function(event) {
  	self.skipWaiting();
  	// console.log('Installed', event);
});

self.addEventListener('activate', function(event) {
  	// console.log('Activated', event);
});




self.addEventListener('push', function(event) {
	self.registration.pushManager.getSubscription().then(subscription => {
	        var sub = subscription,
	           	mergedEndpoint = endpointWorkaround(sub),
                endpointSections = mergedEndpoint.split('/'),
                subscriptionId = endpointSections[endpointSections.length - 1];

		    fetch('php_actions/notification_get_message.php?subscription_id=' + subscriptionId).then(function(response) {
		        // Examine the text in the response  
		        return response.json().then(function(data) { 
		            var title = data.title,
		            	body = data.body,
		            	icon = 'images/icon.png',
		            	notificationTag = data.url;
		            
		            return self.registration.showNotification(title, {
		            	body: body,
		            	icon: icon, 
		            	tag: notificationTag
		            });
		        });
		    });

	});



});

function endpointWorkaround(pushSubscription) {
    // Make sure we only mess with GCM
    if (pushSubscription.endpoint.indexOf('https://android.googleapis.com/gcm/send') !== 0) {
        return pushSubscription.endpoint;
    }

    mergedEndpoint = pushSubscription.endpoint;
    // Chrome 42 + 43 will not have the subscriptionId attached
    // to the endpoint.
    
    if (pushSubscription.subscriptionId && pushSubscription.endpoint.indexOf(pushSubscription.subscriptionId) === -1) {
        // Handle version 42 where you have separate subId and Endpoint
        mergedEndpoint = pushSubscription.endpoint + '/' + pushSubscription.subscriptionId;
    }
    
    return mergedEndpoint;
}

self.addEventListener('notificationclick', function(event) {
  	console.log('Notification click: tag', event.notification.tag);

  	console.log('Notification click: tag', event);

  	// Android doesn't close the notification when you click it
  	// See http://crbug.com/463146
  	event.notification.close();

  	// var url = 'https://youtu.be/gYMkEMCHtJ4';
  	var url = event.notification.tag;

  	// Check if there's already a tab open with this URL.
  	// If yes: focus on the tab.
  	// If no: open a tab with the URL.
  	event.waitUntil(
    	clients.matchAll({
      		type: 'window'
    	}).then(function(windowClients) {
      		console.log('WindowClients', windowClients);
      		for (var i = 0; i < windowClients.length; i++) {
        		var client = windowClients[i];
        		console.log('WindowClient', client);
        		if (client.url === url && 'focus' in client) {
          			return client.focus();
        		}
      		}

      		if (clients.openWindow) {
        		return clients.openWindow(url);
      		}
    	})
  	);
});