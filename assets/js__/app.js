    var config = {
        apiKey: "AIzaSyAELe3JgZ3-bVLuCZWfqP-YMpCl_FZW3Ig",
        authDomain: "newproject-157016.firebaseapp.com",
        databaseURL: "https://newproject-157016.firebaseio.com",
        storageBucket: "newproject-157016.appspot.com",
        messagingSenderId: "343200858963"
};
firebase.initializeApp(config);
function SendToken(token){
    var xmlHttp = new XMLHttpRequest();
    var data=new FormData();
    data.append('token',token)
    xmlHttp.open( "POST", "saveTokenNumber.php", false ); // false for synchronous request
    xmlHttp.send(data);
}
const messaging =firebase.messaging();
messaging.requestPermission()
.then(function(){
    console.log('Have Permission');
    return messaging.getToken();
}).then(function(token){
    console.log(token)
    SendToken(token);
}).catch(function(err){
        console.log('Error Occured'+err);
});
messaging.onMessage(function(payload){
    //console.log(payload.notification);
    //console.log(payload.notification)
    var notification = new Notification(payload.notification.title, {
        icon: payload.notification.icon,
        body: payload.notification.body,
    });
    notification.onclick = function () {
        window.open(payload.notification.click_action);
    };
});
