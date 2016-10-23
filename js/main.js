var reg, 
    sub,
    subscriptionId,
    mergedEndpoint,
    endpointSections;

$(document).ready(function() {

    if (navigator.serviceWorker != null && navigator.serviceWorker.controller == null) {
        $('#push-notification-modal').modal('show');
    } else if (navigator.serviceWorker != null && navigator.serviceWorker.controller != null) {
        // place subscription object to 'sub' variable
        navigator.serviceWorker.ready.then(function(serviceWorkerRegistration) {
            serviceWorkerRegistration.pushManager.getSubscription().then(function(subscription) {
                reg = serviceWorkerRegistration;
                sub = subscription;

                mergedEndpoint = endpointWorkaround(sub);
                endpointSections = mergedEndpoint.split('/');
                subscriptionId = endpointSections[endpointSections.length - 1];

                console.log(subscriptionId);
            });
        });
    } else if (navigator.serviceWorker == null) {
        alert('Not supported in this Browser :(');
    }

    $('.subscribe-push-notification').on('click', function() {
        navigator.serviceWorker.register('sw.js').then(function() {
            return navigator.serviceWorker.ready;
        }).then(function(serviceWorkerRegistration) {
            reg = serviceWorkerRegistration;
            console.log('Service Worker is ready :^)', reg);

            subscribe();
        }).catch(function(error) {
            console.log('Service Worker Error :^(', error);
        });

    });

    $('#unsubscribe-push-notification').on('click', function() {
        unsubscribe();
    });


    $('#send-notification-btn').on('click', function() {
        $.ajax({
            type: 'POST',
            url: 'php_actions/insert_notification_message.php',
            data: {
                title: $('#title').val(),
                body: $('#body').val(),
                url: $('#url').val(),
                subscription_id: subscriptionId
            },
            success: function(data) {
                // alert(data);
            },
            error: function() {
                alert('error');
            }
        })
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



function subscribe() {
    reg.pushManager.subscribe({userVisibleOnly: true}).then(function(subscription) { 
        sub = subscription;

        mergedEndpoint = endpointWorkaround(sub);
        endpointSections = mergedEndpoint.split('/');
        subscriptionId = endpointSections[endpointSections.length - 1];

        $.ajax({
            type: 'POST',
            data: {
                subscription_id: subscriptionId,
                action: 'subscribe'
            },
            url: 'php_actions/registration_actions.php',
            success: function() {
                console.log('success');
                $('#unsubscribe-push-notification').removeClass('hidden');
                $('.subscribe-push-notification').addClass('hidden');
            },
            error: function() {
                console.log('error');
            }
        });

    }).catch(function(err) {
        // registration failed :(
        console.log('ServiceWorker registration failed: ', err);
    });
}

function unsubscribe() {

    reg.unregister().then(function(event) {
        $.ajax({
            type: 'POST',
            data: {
                subscription_id: subscriptionId,
                action: 'unsubscribe'
            },
            url: 'php_actions/registration_actions.php',
            success: function(data) {
                $('#unsubscribe-push-notification').addClass('hidden');
                $('.subscribe-push-notification').removeClass('hidden');
                console.log(data);
                console.log('success');
            },
            error: function() {
                console.log('error');
            }
        });

    }).catch(function(error) {
        console.log('Error unsubscribing', error);
    });
}