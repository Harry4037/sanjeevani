// Initialize Firebase
var config = {
    apiKey: "AIzaSyA8AcswVFHzisREQRKWDlqxQ0c_5OG2RWQ",
    authDomain: "rindex-customer.firebaseapp.com",
    databaseURL: "https://rindex-customer.firebaseio.com",
    projectId: "rindex-customer",
    storageBucket: "rindex-customer.appspot.com",
    messagingSenderId: "430430596289"
};


firebase.initializeApp(config);

// Initialize Cloud Firestore through Firebase
var db = firebase.firestore();

// Disable deprecated features
db.settings({
    timestampsInSnapshots: true
});
