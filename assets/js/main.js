/**
* Template Name: Medilab - v4.9.1
* Template URL: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/
(function() {
  "use strict";

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    let selectEl = select(el, all)
    if (selectEl) {
      if (all) {
        selectEl.forEach(e => e.addEventListener(type, listener))
      } else {
        selectEl.addEventListener(type, listener)
      }
    }
  }

  /**
   * Easy on scroll event listener 
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Scrolls to an element with header offset
   */
  const scrollto = (el) => {
    let header = select('#header')
    let offset = header.offsetHeight

    let elementPos = select(el).offsetTop
    window.scrollTo({
      top: elementPos - offset,
      behavior: 'smooth'
    })
  }

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = select('#header')
  let selectTopbar = select('#topbar')
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled')
        if (selectTopbar) {
          selectTopbar.classList.add('topbar-scrolled')
        }
      } else {
        selectHeader.classList.remove('header-scrolled')
        if (selectTopbar) {
          selectTopbar.classList.remove('topbar-scrolled')
        }
      }
    }
    window.addEventListener('load', headerScrolled)
    onscroll(document, headerScrolled)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }

  /**
   * Mobile nav toggle
   */
  on('click', '.mobile-nav-toggle', function(e) {
    select('#navbar').classList.toggle('navbar-mobile')
    this.classList.toggle('bi-list')
    this.classList.toggle('bi-x')
  })

  /**
   * Mobile nav dropdowns activate
   */
  on('click', '.navbar .dropdown > a', function(e) {
    if (select('#navbar').classList.contains('navbar-mobile')) {
      e.preventDefault()
      this.nextElementSibling.classList.toggle('dropdown-active')
    }
  }, true)

  /**
   * Scrool with ofset on links with a class name .scrollto
   */
  on('click', '.scrollto', function(e) {
    if (select(this.hash)) {
      e.preventDefault()

      let navbar = select('#navbar')
      if (navbar.classList.contains('navbar-mobile')) {
        navbar.classList.remove('navbar-mobile')
        let navbarToggle = select('.mobile-nav-toggle')
        navbarToggle.classList.toggle('bi-list')
        navbarToggle.classList.toggle('bi-x')
      }
      scrollto(this.hash)
    }
  }, true)

  /**
   * Scroll with ofset on page load with hash links in the url
   */
  window.addEventListener('load', () => {
    if (window.location.hash) {
      if (select(window.location.hash)) {
        scrollto(window.location.hash)
      }
    }
  });

  /**
   * Preloader
   */
  let preloader = select('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove()
    });
  }

  /**
   * Initiate glightbox 
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Initiate Gallery Lightbox 
   */
  const galelryLightbox = GLightbox({
    selector: '.galelry-lightbox'
  });

  /**
   

  /**
   * Initiate Pure Counter 
   */
  new PureCounter();

})()


docarray = [
  {
    'Name': "Tsifsa ropt",
    'Specialty': "Kardiologos",
    "location": "Thessaloniki"
  },
  {
    'Name': "Makis Kenteris",
    'Specialty': "Gynaikologos",
    "location": "Athina"
  },
  {
    'Name': "Dafni",
    'Specialty': "peologos",
    "location": "Patra"
  },
  {
    'Name': "Tsifsa",
    'Specialty': "Kardiologos",
    "location": "Karditsa"
  }
]
// document.getElementById("anythingSearch").addEventListener("keyup",function(){
//   let text = document.getElementById("anythingSearch").value;

//   filterarray= docarray.filter(function(a){
//     if (a.Name.includes(text)){
//       return a.Name;
//     }
//   })
  
// })

const login = document.getElementById("login");
const change = document.querySelector(".switch");
const loginbutton = document.querySelector(".login");
const registerbutton = document.querySelector(".register");
const label = document.getElementById("ModalLabel");
const info = document.querySelector(".registerfields");
const login_submit_but = document.getElementById("login_button");
const register_submit_but = document.getElementById("register_button");
const docRegCheckbox = document.querySelector('#flexCheckDefault');
const specialty = document.querySelector('#specialtyInput');
const form = document.getElementById("login_register_form");

function LoginBut(){
  loginbutton.classList.toggle("active");
  registerbutton.classList.remove("active");
  change.classList.remove("active");
  label.innerHTML="Login";
  info.style.display="none";
  register_submit_but.style.display="none";
  login_submit_but.style.display="block";
}


function RegisterBut(){
  registerbutton.classList.toggle("active");
  change.classList.toggle("active");
  loginbutton.classList.remove("active");
  label.innerHTML="Register";
  info.style.display="block";
  login_submit_but.style.display="none";
  register_submit_but.style.display="block";
}

docRegCheckbox.addEventListener('click', function() {
  if (this.checked) {
      specialty.disabled = false;
  } else {
    specialty.disabled = true;
  }
});

