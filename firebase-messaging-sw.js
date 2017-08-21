importScripts('https://www.gstatic.com/firebasejs/3.5.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/3.5.2/firebase-messaging.js');
var config = {
    apiKey: "AIzaSyBvZKV3CO2J5MiHwii-RLEUwRAA3fxWto8",
    authDomain: "newproject-157016.firebaseapp.com",
    databaseURL: "https://newproject-157016.firebaseio.com",
    storageBucket: "newproject-157016.appspot.com",
    messagingSenderId: "984881592366"
};
firebase.initializeApp(config);

const messaging = firebase.messaging();


messaging.setBackgroundMessageHandler(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = 'Background Message Title';
    const notificationOptions = {
        body: 'Background Message body.',
        icon: '/firebase-logo.png'
    };

    return self.registration.showNotification(notificationTitle,
        notificationOptions);
});