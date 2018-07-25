function addLoadEvent(func) {
    var oldonload = window.onload;
    if (typeof window.onload != 'function') {
        window.onload = func;
    } else {
        window.onload = function() {
            if (oldonload) {
                oldonload();
            }
            func();
        }
    }
}

addLoadEvent(function(){
    outdatedBrowser({
        bgColor: tify.outdatedBrowser.bgColor,
        color: tify.outdatedBrowser.color,
        lowerThan: tify.outdatedBrowser.lowerThan,
        languagePath: tify.outdatedBrowser.languagePath
    })
});