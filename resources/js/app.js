
var web_app = window.Telegram.WebApp;

var output = '';
for (var web_apps in web_app) {
    output += web_apps + ': ' + web_app[web_apps]+'; ';
}

window.onload = function() {
    document.getElementById("logs").innerHTML = output;
}

console.log(web_apps);
// $('#UserUsername').html('Welcome Back ' + User.username);
// $('#UserImage').src(User.photoUrl);
