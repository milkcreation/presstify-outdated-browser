"use strict";

let outdatedBrowser = function(options) {
    let self = outdatedBrowser;

    //Variable definition (before ajax)
    let outdated = document.getElementById("outdated");

    // Default settings
    self.defaultOpts = {
        bgColor: '#f25648',
        color: '#ffffff',
        lowerThan: 'transform',
        languagePath: '../outdatedbrowser/lang/en.html'
    };

    if (options) {
        //assign css3 property or js property to IE browser version
        if (options.lowerThan === 'IE8' || options.lowerThan === 'borderSpacing') {
            options.lowerThan = 'borderSpacing';
        } else if (options.lowerThan === 'IE9' || options.lowerThan === 'boxShadow') {
            options.lowerThan = 'boxShadow';
        } else if (options.lowerThan === 'IE10' || options.lowerThan === 'transform' || options.lowerThan === '' || typeof options.lowerThan === "undefined") {
            options.lowerThan = 'transform';
        } else if (options.lowerThan === 'IE11' || options.lowerThan === 'borderImage') {
            options.lowerThan = 'borderImage';
        }  else if (options.lowerThan === 'Edge' || options.lowerThan === 'js:Promise') {
            options.lowerThan = 'js:Promise';
        }

        //all properties
        self.defaultOpts.bgColor = options.bgColor;
        self.defaultOpts.color = options.color;
        self.defaultOpts.lowerThan = options.lowerThan;
        self.defaultOpts.languagePath = options.languagePath;

        self.bkgColor = self.defaultOpts.bgColor;
        self.txtColor = self.defaultOpts.color;
        self.cssProp = self.defaultOpts.lowerThan;
        self.languagePath = self.defaultOpts.languagePath;
    } else {
        self.bkgColor = self.defaultOpts.bgColor;
        self.txtColor = self.defaultOpts.color;
        self.cssProp = self.defaultOpts.lowerThan;
        self.languagePath = self.defaultOpts.languagePath;
    } //end if options


    //Define opacity and fadeIn/fadeOut functions
    let done = true;

    function function_opacity(opacity_value) {
        outdated.style.opacity = opacity_value / 100;
        outdated.style.filter = 'alpha(opacity=' + opacity_value + ')';
    }

    // function function_fade_out(opacity_value) {
    //     function_opacity(opacity_value);
    //     if (opacity_value == 1) {
    //         outdated.style.display = 'none';
    //         done = true;
    //     }
    // }

    function function_fade_in(opacity_value) {
        function_opacity(opacity_value);
        if (opacity_value === 1) {
            outdated.style.display = 'block';
        }
        if (opacity_value === 100) {
            done = true;
        }
    }

    //check if element has a particular class
    // function hasClass(element, cls) {
    //     return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
    // }

    let supports = ( function() {
        let div = document.createElement('div');
        let vendors = 'Khtml Ms O Moz Webkit'.split(' ');
        let len = vendors.length;

        return function(prop) {
            if (prop in div.style) return true;

            prop = prop.replace(/^[a-z]/, function(val) {
                return val.toUpperCase();
            });

            while (len--) {
                if (vendors[len] + prop in div.style) {
                    return true;
                }
            }
            return false;
        };
    } )();

    let validBrowser = false;

    // browser check by js props
    if(/^js:+/g.test(self.cssProp)) {
        let jsProp = self.cssProp.split(':')[1];
        if(!jsProp)
            return;

        switch (jsProp) {
            case 'Promise':
                validBrowser = window.Promise !== undefined && window.Promise !== null && Object.prototype.toString.call(window.Promise.resolve()) === '[object Promise]';
                break;
            default:
                validBrowser = false;
        }
    } else {
        // check by css3 property (transform=default)
        validBrowser = supports('' + self.cssProp + '');
    }


    if (!validBrowser) {
        if (done && outdated.style.opacity !== '1') {
            done = false;
            for (var i = 1; i <= 100; i++) {
                setTimeout((function (x) {
                    return function () {
                        function_fade_in(x);
                    };
                })(i), i * 8);
            }
        }
    } else {
        return;
    } //end if


    //Check AJAX Options: if languagePath == '' > use no Ajax way, html is needed inside <div id="outdated">
    if (self.languagePath === ' ' || self.languagePath.length === 0) {
        startStylesAndEvents();
    } else {
        grabFile(self.languagePath);
    }

    //events and colors
    function startStylesAndEvents() {
        let btnClose = document.getElementById("btnCloseUpdateBrowser");
        let btnUpdate = document.getElementById("btnUpdateBrowser");

        //check settings attributes
        outdated.style.backgroundColor = self.bkgColor;
        //way too hard to put !important on IE6
        outdated.style.color = self.txtColor;
        outdated.children[0].style.color = self.txtColor;
        outdated.children[1].style.color = self.txtColor;

        //check settings attributes
        btnUpdate.style.color = self.txtColor;
        // btnUpdate.style.borderColor = txtColor;
        if (btnUpdate.style.borderColor) {
            btnUpdate.style.borderColor = self.txtColor;
        }
        btnClose.style.color = self.txtColor;

        //close button
        btnClose.onmousedown = function() {
            outdated.style.display = 'none';
            return false;
        };

        //Override the update button color to match the background color
        btnUpdate.onmouseover = function() {
            btnUpdate.style.color = self.bkgColor;
            btnUpdate.style.backgroundColor = self.txtColor;
        };
        btnUpdate.onmouseout = function() {
            btnUpdate.style.color = self.txtColor;
            btnUpdate.style.backgroundColor = self.bkgColor;
        };
    } //end styles and events


    // IF AJAX with request ERROR > insert english default
    let ajaxEnglishDefault = '<h6>Your browser is out-of-date!</h6>' +
        '<p>Update your browser to view this website correctly. <a id="btnUpdateBrowser" href="http://outdatedbrowser.com/">Update my browser now </a></p>' +
        '<p class="last"><a href="#" id="btnCloseUpdateBrowser" title="Close">&times;</a></p>';


    //** AJAX FUNCTIONS - Bulletproof Ajax by Jeremy Keith **
    function getHTTPObject() {
        let xhr = false;
        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        } else if (window.ActiveXObject) {
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } catch ( e ) {
                try {
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                } catch ( e ) {
                    xhr = false;
                }
            }
        }
        return xhr;
    }//end function

    function grabFile(file) {
        let request = getHTTPObject();
        if (request) {
            request.onreadystatechange = function() {
                displayResponse(request);
            };
            request.open("GET", file, true);
            request.send(null);
        }
        return false;
    } //end grabFile

    function displayResponse(request) {
        let insertContentHere = document.getElementById("outdated");
        if (request.readyState === 4) {
            if (request.status === 200 || request.status === 304) {
                insertContentHere.innerHTML = request.responseText;
            } else {
                insertContentHere.innerHTML = ajaxEnglishDefault;
            }
            startStylesAndEvents();
        }
        return false;
    }//end displayResponse

////////END of outdatedBrowser function
};

function addLoadEvent(func) {
    let oldonload = window.onload;
    if (typeof window.onload !== 'function') {
        window.onload = func;
    } else {
        window.onload = function() {
            if (oldonload) {
                oldonload();
            }
            func();
        };
    }
}

addLoadEvent(function(){
    outdatedBrowser({
        bgColor: tify.outdatedBrowser.bgColor,
        color: tify.outdatedBrowser.color,
        lowerThan: tify.outdatedBrowser.lowerThan,
        languagePath: tify.outdatedBrowser.languagePath
    });
});