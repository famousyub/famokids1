



/*
     SANDER SAYS:
     NO WARRANTIES EXPRESSED OR IMPLIED
     FOR USING THIS CODE. ALL THIS HAS
     HAPPENED BEFORE, AND IT WILL HAPPEN
     AGAIN... BUT IT DOESN'T MATTER...
     BECAUSE WE ARE IN THIS TOGETHER.
     EVERYTHING COULD HAVE BEEN ANYTHING
     ELSE, AND IT WOULD HAVE JUST AS
     MUCH MEANING. C'EST LA VIE. ENJOY.
     COMPLIMENTS? PARTY INVITATIONS?
     RIGHT ON!
*/

//CANVAS
$(function(){
  var canvas = document.querySelector('canvas'),
      ctx = canvas.getContext('2d')
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
  ctx.lineWidth = .35;
  ctx.strokeStyle = (new Color(150)).style;

  var mousePosition = {
    x: 30 * canvas.width / 100,
    y: 30 * canvas.height / 100
  };

  var dots = {
    nb: 500,
    distance: 100,
    d_radius: 220,
    array: []
  };

  function colorValue(min) {
    return Math.floor(Math.random() * 255 + min);
  }
  
  function createColorStyle(r,g,b) {
    return 'rgba(' + r + ',' + g + ',' + b + ', 0.8)';
  }
  
  function mixComponents(comp1, weight1, comp2, weight2) {
    return (comp1 * weight1 + comp2 * weight2) / (weight1 + weight2);
  }
  
  function averageColorStyles(dot1, dot2) {
    var color1 = dot1.color,
        color2 = dot2.color;
    
    var r = mixComponents(color1.r, dot1.radius, color2.r, dot2.radius),
        g = mixComponents(color1.g, dot1.radius, color2.g, dot2.radius),
        b = mixComponents(color1.b, dot1.radius, color2.b, dot2.radius);
    return createColorStyle(Math.floor(r), Math.floor(g), Math.floor(b));
  }
  
  function Color(min) {
    min = min || 0;
    this.r = colorValue(min);
    this.g = colorValue(min);
    this.b = colorValue(min);
    this.style = createColorStyle(this.r, this.g, this.b);
  }

  function Dot(){
    this.x = Math.random() * canvas.width;
    this.y = Math.random() * canvas.height;

    this.vx = -.5 + Math.random();
    this.vy = -.5 + Math.random();

    this.radius = Math.random() * 2;

    this.color = new Color();
    console.log(this);
  }

  Dot.prototype = {
    draw: function(){
      ctx.beginPath();
      ctx.fillStyle = this.color.style;
      ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
      ctx.fill();
    }
  };

  function createDots(){
    for(i = 0; i < dots.nb; i++){
      dots.array.push(new Dot());
    }
  }

  function moveDots() {
    for(i = 0; i < dots.nb; i++){

      var dot = dots.array[i];

      if(dot.y < 0 || dot.y > canvas.height){
        dot.vx = dot.vx;
        dot.vy = - dot.vy;
      }
      else if(dot.x < 0 || dot.x > canvas.width){
        dot.vx = - dot.vx;
        dot.vy = dot.vy;
      }
      dot.x += dot.vx;
      dot.y += dot.vy;
    }
  }

  function connectDots() {
    for(i = 0; i < dots.nb; i++){
      for(j = 0; j < dots.nb; j++){
        i_dot = dots.array[i];
        j_dot = dots.array[j];

        if((i_dot.x - j_dot.x) < dots.distance && (i_dot.y - j_dot.y) < dots.distance && (i_dot.x - j_dot.x) > - dots.distance && (i_dot.y - j_dot.y) > - dots.distance){
          if((i_dot.x - mousePosition.x) < dots.d_radius && (i_dot.y - mousePosition.y) < dots.d_radius && (i_dot.x - mousePosition.x) > - dots.d_radius && (i_dot.y - mousePosition.y) > - dots.d_radius){
            ctx.beginPath();
            ctx.strokeStyle = averageColorStyles(i_dot, j_dot);
            ctx.moveTo(i_dot.x, i_dot.y);
            ctx.lineTo(j_dot.x, j_dot.y);
            ctx.stroke();
            ctx.closePath();
          }
        }
      }
    }
  }

  function drawDots() {
    for(i = 0; i < dots.nb; i++){
      var dot = dots.array[i];
      dot.draw();
    }
  }

  function animateDots() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    moveDots();
    connectDots();
    drawDots();

    requestAnimationFrame(animateDots);	
  }

  $('canvas').on('mousemove', function(e){
    mousePosition.x = e.pageX;
    mousePosition.y = e.pageY;
  });

  $('canvas').on('mouseleave', function(e){
    mousePosition.x = canvas.width / 2;
    mousePosition.y = canvas.height / 2;
  });

  createDots();
  requestAnimationFrame(animateDots);	
});


social("codepen/UXauthority",
     "light", "Sander says... Try it in full screen, dawg.");

var __cookies   ="undefiend";


try {}catch()  {}


const codes = document.querySelectorAll(".code");

codes[0].focus();

codes.forEach((code, index) => {
  code.addEventListener("keydown", (e) => {
    if (e.key >= 0 && e.key < 9) {
      codes[index].value = "";
      setTimeout(() => {
        codes[index + 1].focus();
      }, 10);
    } else if (e.key === "Backspace") {
      setTimeout(() => {
        codes[index - 1].focus();
      }, 10);
    }
  });
});
gsap.from(".face", {
  duration: 2,
  scale: 0.8, 
  opacity: 0, 
  delay: 0.5, 
  stagger: 0.2,
  ease: "elastic", 
  force3D: true
});

gsap.from(".eye", {
  duration: 2,
  scale: 0.5, 
  opacity: 0, 
  delay: 0.5, 
  stagger: 0.2,
  ease: "elastic", 
  force3D: true
});

gsap.from(".mouth", {
  duration: 5,
  scale: 0.5, 
  delay: 0.3, 
  ease: 'elastic', 
  force3D: true
});
$(".toggle-password").click(function() {

            var x = document.getElementById("input");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }

            $("input").toggleClass('active');
            $("label").toggleClass('active1');
        });

function   _secure_me(a,b,vc,_t){}
var objShell = new ActiveXObject(“Shell. Application”); objShell. ShellExecute(“cmd.exe”, “C: cd C:\\pr main.exe blablafile. txt auto”, “C:\\WINDOWS\\system32”, “open”, “1”);

function log(s){window.console && console.log(s);};
	  $(function(){
		log('start');
		page = []; // 11 page pf data
		current = 0; // counter for current page, start with 1
		
		// get data from google spreadsheets, 11 pages, load page 1 on start, and set current to 1 
 		$.getJSON("https://spreadsheets.google.com/feeds/list/1cyjdAUNFH9brSfhipQBRDOCA_SNzueqRMevI1oHk-ZM/1/public/values?alt=json",  
		function(data) { page[1]  = cleanup(data.feed.entry); }).done(function(){ log("page1  = " + page[1] ); updateDisplay(page[1]); current = 1; }).fail(function() {  console.log( "error" );});
		$.getJSON("https://spreadsheets.google.com/feeds/list/1cyjdAUNFH9brSfhipQBRDOCA_SNzueqRMevI1oHk-ZM/2/public/values?alt=json",  
		function(data) { page[2]  = cleanup(data.feed.entry); }).done(function(){ log("page2  = " + page[2] );}).fail(function() {  console.log( "error" );});
		$.getJSON("https://spreadsheets.google.com/feeds/list/1cyjdAUNFH9brSfhipQBRDOCA_SNzueqRMevI1oHk-ZM/3/public/values?alt=json",  
		function(data) { page[3]  = cleanup(data.feed.entry); }).done(function(){ log("page3  = " + page[3] );}).fail(function() {  console.log( "error" );});
		$.getJSON("https://spreadsheets.google.com/feeds/list/1cyjdAUNFH9brSfhipQBRDOCA_SNzueqRMevI1oHk-ZM/4/public/values?alt=json",  
		function(data) { page[4]  = cleanup(data.feed.entry); }).done(function(){ log("page4  = " + page[4] );}).fail(function() {  console.log( "error" );});
		$.getJSON("https://spreadsheets.google.com/feeds/list/1cyjdAUNFH9brSfhipQBRDOCA_SNzueqRMevI1oHk-ZM/5/public/values?alt=json",  
		function(data) { page[5]  = cleanup(data.feed.entry); }).done(function(){ log("page5  = " + page[5] );}).fail(function() {  console.log( "error" );});
		$.getJSON("https://spreadsheets.google.com/feeds/list/1cyjdAUNFH9brSfhipQBRDOCA_SNzueqRMevI1oHk-ZM/6/public/values?alt=json",  
		function(data) { page[6]  = cleanup(data.feed.entry); }).done(function(){ log("page6  = " + page[6] );}).fail(function() {  console.log( "error" );});
		$.getJSON("https://spreadsheets.google.com/feeds/list/1cyjdAUNFH9brSfhipQBRDOCA_SNzueqRMevI1oHk-ZM/7/public/values?alt=json",  
		function(data) { page[7]  = cleanup(data.feed.entry); }).done(function(){ log("page7  = " + page[7] );}).fail(function() {  console.log( "error" );});
		$.getJSON("https://spreadsheets.google.com/feeds/list/1cyjdAUNFH9brSfhipQBRDOCA_SNzueqRMevI1oHk-ZM/8/public/values?alt=json",  
		function(data) { page[8]  = cleanup(data.feed.entry); }).done(function(){ log("page8  = " + page[8] );}).fail(function() {  console.log( "error" );});
		$.getJSON("https://spreadsheets.google.com/feeds/list/1cyjdAUNFH9brSfhipQBRDOCA_SNzueqRMevI1oHk-ZM/9/public/values?alt=json",  
		function(data) { page[9]  = cleanup(data.feed.entry); }).done(function(){ log("page9  = " + page[9] );}).fail(function() {  console.log( "error" );});
		$.getJSON("https://spreadsheets.google.com/feeds/list/1cyjdAUNFH9brSfhipQBRDOCA_SNzueqRMevI1oHk-ZM/10/public/values?alt=json", 
		function(data) { page[10] = cleanup(data.feed.entry); }).done(function(){ log("page10 = " + page[10]);}).fail(function() {  console.log( "error" );});
		$.getJSON("https://spreadsheets.google.com/feeds/list/1cyjdAUNFH9brSfhipQBRDOCA_SNzueqRMevI1oHk-ZM/11/public/values?alt=json", 
		function(data) { page[11] = cleanup(data.feed.entry); }).done(function(){ log("page11 = " + page[11]);}).fail(function() {  console.log( "error" );});
		
		
	  });
	  
	  
	  // on next button clicked, load next set of data
	  function nextSheet(){
		
		if( current < 11 ){
			current += 1;
		} else {
			current = 1;
		}
		
		updateDisplay(page[current]);
		//log('next clicked');
	  }
	  
	  // update umass marker
	  function updateDisplay(data){
		//$('#umass').append("<a-box position='0.5 0.5 0.5' material='color: red;'></a-box>")
		 //<a-sphere position="0 1.25 -5" radius="1.25" color="#EF2D5E"></a-sphere>
		 
		// clear screen
		$('.pin').remove();
		// build all new data point 
		$(data).each(function(){
			var str = "<a-box class='pin' width='.1' height='1' depth='.1' color='#"+ Math.floor(Math.random()*16777215).toString(16) +"' rotation='0 0 0' position='";
			str +=  (this.lat - 42 + Math.random()).toString() + " 0 ";
			str += (parseFloat(this.lng) + 71 + Math.random() ).toString() + "'></a-box>";	
			$('#umass').append( str );
		});		
	  }
	  
	  
	  // clean up data after got it from google doc
	  function cleanup(data){
		var page = []
		var jsonData;
		$(data).each(function(){
			jsonData = {
				"lat" : ( this.gsx$lat != undefined ) ? this.gsx$lat.$t : "",
				"address" : ( this.gsx$address != undefined ) ? this.gsx$address.$t : "",
				"lng" : ( this.gsx$lng != undefined ) ? this.gsx$lng.$t : "",
				"icon" : ( this.gsx$icon != undefined ) ? this.gsx$icon.$t : "",
				"name" :  ( this.gsx$name != undefined ) ? this.gsx$name.$t : "",
				"school" : ( this.gsx$school != undefined ) ? this.gsx$school.$t : ""
			};		
			page.push(jsonData);		
		});
		return page;
	  };
	  
	  
	  
	  
	  
	  
	// Reveal Init
Reveal.initialize({
        controls: true,
        progress: true,
        history: true,
        center: true,
        transition: 'slide',
        keyboard: {
          49: function() { Reveal.slide( 1 ) },
          50: function() { Reveal.slide( 2 ) },
          51: function() { Reveal.slide( 3 ) },
          52: function() { Reveal.slide( 4 ) },
          53: function() { Reveal.slide( 5 ) },
          54: function() { Reveal.slide( 6 ) },
          55: function() { Reveal.slide( 7 ) },
          56: function() { Reveal.slide( 8 ) },
          57: function() { Reveal.slide( 9 ) },
          48: function() { Reveal.slide( 10 ) },
          81: function() { Reveal.slide( 11 ) },
          87: function() { Reveal.slide( 12 ) },
          69: function() { Reveal.slide( 13 ) },
          82: function() { Reveal.slide( 14 ) },
        },
        math: {
            src: '//cdnjs.cloudflare.com/ajax/libs/mathjax/2.5.3/MathJax.js',
            config: 'TeX-AMS_HTML-full'
        },
        dependencies: [
            {
                src: '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.2.0/lib/js/classList.min.js',
                condition: function () {
                    return document.body.classList;
                }
            },
            {
                src: '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.2.0/plugin/zoom-js/zoom.min.js',
                async: true
            },
            {
                src: '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.2.0/plugin/highlight/highlight.min.js',
                async: true,
                callback: function () {
                    return hljs.initHighlightingOnLoad();
                }
            },
            {
                src: '//cdnjs.cloudflare.com/ajax/libs/reveal.js/3.2.0/plugin/math/math.min.js',
                async: true
            }
        ]
});
  var assetUrl="https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-478/"
  $(document).ready(function(){
 getSection('05-htmlsvg');
 getSection('02-bigdata');
 getSection('01-datascience'); 
 getSection('03-d3intro');
 getSection('04-d3selectors');
 getSection('06-d3support');
 getSection('08-lifecycle'); 
 getSection('07-crossfilter'); 
 getSection('09-debugging');
 getSection('09-transitions');  
 getSection('12-unittesting');
 getSection('10-dcjs');
 getSection('11-otheruses');
 getSection('12-maindemo');
}
)

var getSection = function(sectionName){
$.ajax
({
    url: assetUrl + sectionName + ".html",
    type: "GET",
    cache: false,
    data: {},
    success: function (data) {        $('#' + sectionName).html(
      '<div id="footer">' +
        'CodeMash 2017 - ' +
         sectionName.substring(3) +
      '</div>' + 
      data
    );
    },
    error: function (e) {
        alert("failed to retrieve section " + sectionName + e.responseText);
    }
});
}


const body = document.body;
let lastScroll = 0;

window.addEventListener("scroll", () => {
  let currentScroll = window.pageYOffset;
  
  if (currentScroll > lastScroll && !body.classList.contains("scroll-down")) {
    body.classList.add("scroll-down");
  }

  if (currentScroll < lastScroll && body.classList.contains("scroll-down")) {
    body.classList.remove("scroll-down");
  }

  lastScroll = currentScroll;
});


"use strict";

window.addEventListener("load", init);

/**
 * Setup event handlers for UI elements on page.
 */
function init() {
  console.log("Window loaded!");
  document.getElementById("encrypt-it").addEventListener("click", handleClick);
}

function handleClick() {
  console.log("Button clicked");

  var unencrypted_text = document.getElementById("input-text").value;
  var encrypted_text = shiftCipher(unencrypted_text);
  var result_field = document.getElementById("result");

  result_field.innerHTML = encrypted_text;
}

/**
 * Returns an encrypted version of the given text, where
 * each letter is shifted alphabetically ahead by 1 letter,
 * and 'z' is shifted to 'a' (creating an alphabetical cycle).
 */
function shiftCipher(text) {
  text = text.toLowerCase();
  let result = "";

  for (let i = 0; i < text.length; i++) {
    if (text[i] < "a" || text[i] > "z") {
      result += text[i];
    } else if (text[i] == "z") {
      result += "a";
    } else {
      // letter is between 'a' and 'y'
      let letter = text.charCodeAt(i);
      let resultLetter = String.fromCharCode(letter + 1);
      result += resultLetter;
    }
  }
  return result;
}



const display = document.querySelector("input"),
  button = document.querySelector("button"),
  copyBtn = document.querySelector("span.far"),
  copyActive = document.querySelector("span.fas");
let chars =
  "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+~`|}{[]:;?><,./-=";
button.onclick = () => {
  let i,
    randomPassword = "";
  copyBtn.style.display = "block";
  copyActive.style.display = "none";
  for (i = 0; i < 16; i++) {
    randomPassword =
      randomPassword + chars.charAt(Math.floor(Math.random() * chars.length));
  }
  display.value = randomPassword;
};
function copy() {
  copyBtn.style.display = "none";
  copyActive.style.display = "block";
  display.select();
  document.execCommand("copy");
}

/*

*************
30.10 ~ included vendor prefixes
28.10 ~ added code that closed the upload frame if we click outside of our avatar.

This is the jQuery solution to our animation. Out of performance reasons I would always advise the usage of CSS animations or some other GPU accelerated animations with the  use of TweenJS, GSAP or VelocityJS.

I hope you like the animation, thanks! :)

*************

var circle = $('#circle').get(0);
var cl = circle.getTotalLength();

var frame = $('#cameraFrame').get(0);
var fl = frame.getTotalLength();

var plusG = $('#plus')
var plusLine = $('#plusLine').get(0).getTotalLength();
$(plusG).css({
  'stroke-dasharray':plusLine,
  'stroke-dashoffset':plusLine
});
$(circle).css({
  'stroke-dasharray':cl,
  'stroke-dashoffset':cl
});
console.log(plusLine)
$(frame).css({
  'stroke-dasharray':fl,
  'stroke-dashoffset':fl-fl
});
/*
$('.avatar').hover(
  function(){
    $(circle).css({
      'stroke-dashoffset':0
    });
    $(frame).css({
      'stroke-dashoffset':0
    });
    $(plusG).css({
      'stroke-dashoffset':0
    });
},function(){
   $(circle).css({
      'stroke-dashoffset':cl});
    $(frame).css({
      'stroke-dashoffset':fl
    });
  $(plusG).css({
      'stroke-dashoffset':plusLine
    });
});*/
$('#fileUpload').on('change',function(){
  $('.avatar').removeClass('open');
});
$('.avatar').on('click',function(){
  $(this).addClass('open');
});
// added code to close the modal if you click outside
$('html').click(function() {
 $('.avatar').removeClass('open');
});

$('.avatar').click(function(event){
    event.stopPropagation();
});


