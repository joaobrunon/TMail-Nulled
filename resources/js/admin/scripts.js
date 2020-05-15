$(document).ready(function() {
    $("#addDomain").click(function(){
        $("#addDomain").before('<div class="domains"><input type="text" name="domain[]" placeholder="Enter Domain"></div>');
    });
    $("#addAPI").click(function(){
        $("#addAPI").before('<div class="domains"><input type="text" name="api[]" value="'+ randomString(30) +'" placeholder="Enter API Key"></div>');
    });
    $("#addForbidden").click(function(){
        $("#addForbidden").before('<div class="domains"><input type="text" name="forbidden[]" placeholder="Enter Forbidden ID (without domain)"></div>');
    });
});

function randomString(length = 30) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
       result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
 }
 