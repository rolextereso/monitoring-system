// idle.js (c) Alexios Chouchoulas 2009
// Released under the terms of the GNU Public License version 2.0 (or later).

var _API_JQUERY = 1;
var _API_PROTOTYPE = 2;
var _api;
var _idleTimeout = 30000;
var _awayTimeout = 600000;
var _idleNow = false;
var _idleTimestamp = null;
var _idleTimer = null;
var _awayNow = false;
var _awayTimestamp = null;
var _awayTimer = null;

function setIdleTimeout(a) {
    _idleTimeout = a;
    _idleTimestamp = new Date().getTime() + a;
    if (_idleTimer != null) {
        clearTimeout(_idleTimer)
    }
    _idleTimer = setTimeout(_makeIdle, a + 50)
}

function setAwayTimeout(a) {
    _awayTimeout = a;
    _awayTimestamp = new Date().getTime() + a;
    if (_awayTimer != null) {
        clearTimeout(_awayTimer)
    }
    _awayTimer = setTimeout(_makeAway, a + 50)
}

function _makeIdle() {
    var a = new Date().getTime();
    if (a < _idleTimestamp) {
        _idleTimer = setTimeout(_makeIdle, _idleTimestamp - a + 50);
        return
    }
    _idleNow = true;
    try {
        if (document.onIdle) {
            document.onIdle()
        }
    } catch (b) {}
}

function _makeAway() {
    var a = new Date().getTime();
    if (a < _awayTimestamp) {
        _awayTimer = setTimeout(_makeAway, _awayTimestamp - a + 50);
        return
    }
    _awayNow = true;
    try {
        if (document.onAway) {
            document.onAway()
        }
    } catch (b) {}
}

function _initPrototype() {
    _api = _API_PROTOTYPE
}

function _active(c) {
    var a = new Date().getTime();
    _idleTimestamp = a + _idleTimeout;
    _awayTimestamp = a + _awayTimeout;
    if (_idleNow) {
        setIdleTimeout(_idleTimeout)
    }
    if (_awayNow) {
        setAwayTimeout(_awayTimeout)
    }
    try {
        if ((_idleNow || _awayNow) && document.onBack) {
            document.onBack(_idleNow, _awayNow)
        }
    } catch (b) {}
    _idleNow = false;
    _awayNow = false
}

function _initJQuery() {
    _api = _API_JQUERY;
    var a = $(document);
    a.ready(function() {
        a.mousemove(_active);
        try {
            a.mouseenter(_active)
        } catch (b) {}
        try {
            a.scroll(_active)
        } catch (b) {}
        try {
            a.keydown(_active)
        } catch (b) {}
        try {
            a.click(_active)
        } catch (b) {}
        try {
            a.dblclick(_active)
        } catch (b) {}
    })
}

function _initPrototype() {
    _api = _API_PROTOTYPE;
    var a = $(document);
    Event.observe(window, "load", function(b) {
        Event.observe(window, "click", _active);
        Event.observe(window, "mousemove", _active);
        Event.observe(window, "mouseenter", _active);
        Event.observe(window, "scroll", _active);
        Event.observe(window, "keydown", _active);
        Event.observe(window, "click", _active);
        Event.observe(window, "dblclick", _active)
    })
}

try {
    if (Prototype) {
        _initPrototype()
    }
} catch (err) {}
try {
    if (jQuery) {
        _initJQuery()
    }
} catch (err) {}
setIdleTimeout(60000);
setAwayTimeout(300000);
document.onIdle = function() {
   if(getCookie("away")==""){
        setCookie("away","away",1);       
   }
};
document.onAway = function() {
   if(getCookie("away")=="away"){
        auto_log();
       
        _idleNow = false;
        _awayNow = false        
   }
};
document.onBack = function(a, b) {
    if (a) {
        setCookie("away","",1);
    }
    if (b) {
        setCookie("away","",1);
    }
};

function auto_log(){
                get_logout(true);
                bootbox.alert({
                    message: "You been away for the last five minutes. The system will redirect you to login page",
                    callback: function () {
                         delete_cookie();                                                   
                         window.location.href="login.php";  
                    }
                });
}

function logout(){
        bootbox.confirm({
                  size: "small",                                         
                  message: "Are you sure you want to log-out?", 
                  callback: function(result){                         
                        if(result){
                              get_logout();
                        }
                 }
                });
} 

function get_logout(auto=false){
           var url = "phpscript/login/logout.php";
          // POST values in the background the the script URL
          $.ajax({
              type: "GET",
              url: url,                                                                      
              success: function (data)
              {
                 if(data=="logout" && auto==false){ 
                      delete_cookie();                                                   
                      window.location.href="login.php";                                                   
                 }
              }
          });
} 

//this will delete cookie hidealert when the overdue rented alert exists
function delete_cookie(){
    document.cookie="hideAlert=;path=/";
    document.cookie="away=;path=/";
}