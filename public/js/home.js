(function() {
    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame'] || window[vendors[x] + 'CancelRequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function(callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() { callback(currTime + timeToCall); },
                timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };

    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
}());

var php = document.querySelector('#php')
php.style.transformOrigin = 'center'
php.style.WebkitTransformOrigin = 'center'
var percent = 0
var start = Date.now()

function back(progress) {
    var x = 1.3
    return Math.pow(progress, 2) * ((x + 1) * progress - x)
}

function makeEaseOut(delta) {
    return function(progress) {
        return 1 - delta(1 - progress)
    }
}

var delta = makeEaseOut(back)

function round() {
    var rid = requestAnimationFrame(round)
    var current = Date.now()
    var elapse = current - start
    elapse -= 800
    percent = elapse / 2500
    percent = Math.max(0, percent)
    percent = Math.min(1, percent)
    percent = delta(percent)

    if (percent === 1) {
        cancelAnimationFrame(rid)
    }

    var scale = percent * 1
    var angle = Math.PI * 2 * percent - Math.PI * 1 / 4
    var pathR = 38
    var offsetCircle = 11
    var phpR = 18
    var x = Math.cos(angle) * pathR + offsetCircle + phpR
    var y = Math.sin(angle) * pathR + offsetCircle + phpR

    php.style.transform = 'translate3d(' + x + 'px, ' + y + 'px, 0) scale(' + scale + ')'
    php.style.WebkitTransform = 'translate3d(' + x + 'px, ' + y + 'px, 0) scale(' + scale + ')'
}

requestAnimationFrame(round)
