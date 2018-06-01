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
        bgColor: tFy.outdatedBrowser.bgColor,
        color: tFy.outdatedBrowser.color,
        lowerThan: tFy.outdatedBrowser.lowerThan,
        languagePath: tFy.outdatedBrowser.languagePath
    })
});