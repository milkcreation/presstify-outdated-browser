'use strict'

let outdatedBrowser = function (test, element) {
  let self = outdatedBrowser,
      el = element || document.getElementById('outdated'),
      close = document.getElementById('outdated--close')

  if (typeof (el) != 'undefined' && el != null) {
    if (test) {
      if (test === 'IE8' || test === 'borderSpacing') {
        test = 'borderSpacing'
      } else if (test === 'IE9' || test === 'boxShadow') {
        test = 'boxShadow'
      } else if (test === 'IE10' || test === 'transform' || test === '' || typeof test === 'undefined') {
        test = 'transform'
      } else if (test === 'IE11' || test === 'borderImage') {
        test = 'borderImage'
      } else if (test === 'Edge' || test === 'js:Promise') {
        test = 'js:Promise'
      }

      self.cssProp = test
    } else {
      self.cssProp = 'js:Promise'
    }

    let supports = (function () {
      let div = document.createElement('div')
      let vendors = 'Khtml Ms O Moz Webkit'.split(' ')
      let len = vendors.length

      return function (prop) {
        if (prop in div.style) return true

        prop = prop.replace(/^[a-z]/, function (val) {
          return val.toUpperCase()
        })

        while (len--) {
          if (vendors[len] + prop in div.style) {
            return true
          }
        }
        return false
      }
    })()

    let validBrowser = false

    if (/^js:+/g.test(self.cssProp)) {
      let jsProp = self.cssProp.split(':')[1]

      if (!jsProp) {
        return
      }

      switch (jsProp) {
        case 'Promise':
          validBrowser = window.Promise !== undefined && window.Promise !== null && Object.prototype.toString.call(window.Promise.resolve()) === '[object Promise]'
          break
        default:
          validBrowser = false
      }
    } else {
      validBrowser = supports('' + self.cssProp + '')
    }

    function fadeIn(el, display) {
      el.style.opacity = 0
      el.style.display = display || 'block';

      (function fade() {
        let val = parseFloat(el.style.opacity)
        if (!((val += .1) > 1)) {
          el.style.opacity = val
          requestAnimationFrame(fade)
        }
      })()
    }

    function fadeOut(el) {
      el.style.opacity = 1;

      (function fade() {
        if ((el.style.opacity -= .1) < 0) {
          el.style.display = 'none'
        } else {
          requestAnimationFrame(fade)
        }
      })()
    }

    if (!validBrowser) {
      fadeIn(el)
    }

    if (typeof (close) != 'undefined' && close != null) {
      close.addEventListener('click', () => {
        fadeOut(el)
      })
    }
  }
}

export default outdatedBrowser