/**!
* resize only width
* */
var resizeByWidth = true;

var prevWidth = -1;
$(window).on('debouncedresize', function () {
var currentWidth = $('body').outerWidth();
resizeByWidth = prevWidth != currentWidth;
if(resizeByWidth){
$(window).trigger('resizeByWidth');
prevWidth = currentWidth;
}
});
/*resize only width end*/

/**!
* device detected
* */
var DESKTOP = device.desktop();
//console.log('DESKTOP: ', DESKTOP);
var MOBILE = device.mobile();
//console.log('MOBILE: ', MOBILE);
var TABLET = device.tablet();
//console.log('MOBILE: ', MOBILE);
/*device detected end*/

/**!
*  placeholder
*  */
function placeholderInit(){
$('[placeholder]').placeholder();
}
/*placeholder end*/

/**!
*  multiselect init
* */
/*! add ui position add class */
function addPositionClass(position, feedback, obj){
removePositionClass(obj);
obj.css( position );
obj
.addClass( feedback.vertical )
.addClass( feedback.horizontal );
}

/*! add ui position remove class */
function removePositionClass(obj){
obj.removeClass('top');
obj.removeClass('bottom');
obj.removeClass('center');
obj.removeClass('left');
obj.removeClass('right');
}

function customSelect(select){
if ( select.length ) {
selectArray = [];
select.each(function(selectIndex, selectItem){
var placeholderText = $(selectItem).attr('data-placeholder');
var flag = true;
if ( placeholderText === undefined ) {
placeholderText = $(selectItem).find(':selected').html();
flag = false;
}
var classes = $(selectItem).attr('class');
selectArray[selectIndex] = $(selectItem).multiselect({
header: false,
height: 'auto',
minWidth: 50,
selectedList: 1,
classes: classes,
multiple: false,
noneSelectedText: placeholderText,
show: ['fade', 100],
hide: ['fade', 100],
create: function(event){
var select = $(this);
var button = $(this).multiselect('getButton');
var widget = $(this).multiselect('widget');
button.wrapInner('<span class="select-inner"></span>');
button.find('.ui-icon').append('<i class="arrow-select"></i>')
.siblings('span').addClass('select-text');
widget.find('.ui-multiselect-checkboxes li:last')
.addClass('last')
.siblings().removeClass('last');
if ( flag ) {
$(selectItem).multiselect('uncheckAll');
$(selectItem)
.multiselect('widget')
.find('.ui-state-active')
.removeClass('ui-state-active')
.find('input')
.removeAttr('checked');
}
},
selectedText: function(number, total, checked){
var checkedText = checked[0].title;
return checkedText;
},
position: {
my: 'left top',
at: 'left bottom',
using: function( position, feedback ) {
addPositionClass(position, feedback, $(this));
}
}
});
});
$(window).resize(selectResize);
}
}

function selectResize(){
if ( selectArray.length ) {
$.each(selectArray, function(i, el){
var checked = $(el).multiselect('getChecked');
var flag = true;
if ( !checked.length ) {
flag = false
}
$(el).multiselect('refresh');
if ( !flag ) {
$(el).multiselect('uncheckAll');
$(el)
.multiselect('widget')
.find('.ui-state-active')
.removeClass('ui-state-active')
.find('input')
.removeAttr('checked');
}
$(el).multiselect('close');
});
}
}
/* multiselect init end */

/**!
* print
* */
function printShow() {
$('.view-print').on('click', function (e) {
e.preventDefault();
window.print();
})
}
/*print end*/

/**!
* main navigation
* */
(function ($) {
// external js:
// 1) TweetMax VERSION: 1.19.0 (widgets.js);
// 2) device.js 0.2.7 (widgets.js);
// 3) resizeByWidth (resize only width);

// add css style
// .nav-opened{
// 	width: 100%!important;
// 	height: 100%!important;
// 	max-width: 100%!important;
// 	max-height: 100%!important;
// 	margin: 0!important;
// 	padding: 0!important;
// 	overflow: hidden!important;
// }

//.nav-opened-start .wrapper{ z-index: 99; } // z-index of header must be greater than footer
//
// @media only screen and (min-width: [example: 1280px]){
// .nav{
// 		-webkit-transform: translate(0, 0) matrix(1, 0, 0, 1, 0, 0) !important;
// 		-ms-transform: translate(0, 0) matrix(1, 0, 0, 1, 0, 0) !important;
// 		transform: translate(0, 0) matrix(1, 0, 0, 1, 0, 0) !important;
// 	}
// .nav-list > li{
// 		-webkit-transform: translate(0, 0) matrix(1, 0, 0, 1, 0, 0) !important;
// 		-ms-transform: translate(0, 0) matrix(1, 0, 0, 1, 0, 0) !important;
// 		transform: translate(0, 0) matrix(1, 0, 0, 1, 0, 0) !important;
// 		opacity: 1 !important;
// 		visibility: visible !important;
// 	}
// }

var defaults = {
mainContainer: 'html', // container wrapping all elements
navContainer: null, // main navigation container
navMenu: null, // menu
btnMenu: null, // element which opens or switches menu
btnClose: null, // element which closes a menu
navMenuItem: null,
navMenuAnchor: 'a',
staggerElement: null,
overlayClass: 'popup-overlay', // overlay's class
overlayAppendTo: 'body', // where to place overlay
overlayAlpha: 0.8,
overlayIndex: 997,
classReturn: null,
overlayBoolean: true,
animationType: 'ltr', // rtl or ltr
animationScale: 0.85, // default scale for animation
animationSpeed: 300, // animation speed of the main element
animationSpeedOverlay: null, // animation speed of the overlay
alpha: 1,
ease: Cubic.easeOut, // animation (gsap) https://greensock.com/customease
minWidthItem: 100,
mediaWidth: null,
closeOnResize: true,
cssScrollBlocked: false, // add class to body for blocked scroll
closeEsc: true, // close popup on click Esc,
activeClass: 'active',
openedClass: 'extra-popup-opened',
beforeOpenClass: 'extra-popup-before-open',
extraPopupBeforeOpen: null
};

var ExtraPopup = function (settings) {
var options = $.extend(defaults, settings || {});

var container = $(options.navContainer),
_animateSpeed = options.animationSpeed;

var self = this;
self.options = options;
self.$mainContainer = $(options.mainContainer);            // . по умолчанию <html></html>
self.$navMenu = $(options.navMenu);
self.$btnMenu = $(options.btnMenu);
self.$btnClose = $(options.btnClose);
self.$navContainer = container;
self.$navMenuItem = $(options.navMenuItem, container);     // Пункты навигации;
self.$navMenuAnchor = $(options.navMenuAnchor, container); // Элемент, по которому производится событие (клик);
self.$staggerElement = options.staggerElement;  //Элементы в стеке, к которым применяется анимация. По умолчанию null;

self._animationType = options.animationType;
self._animationScale = options.animationScale;
self._animateSpeed = _animateSpeed;
self.ease = options.ease;
self.alpha = options.alpha;

// overlay
self.overlayBoolean = options.overlayBoolean;
self.overlayAppendTo = options.overlayAppendTo;
self.$overlay = $('<div class="' + options.overlayClass.substring(0) + '"></div>'); // Темплейт оверлея;
self._overlayAlpha = options.overlayAlpha;
self._overlayIndex = options.overlayIndex;
self._animateSpeedOverlay = options.animationSpeedOverlay || _animateSpeed;
self._minWidthItem = options.minWidthItem;
self._mediaWidth = options.mediaWidth;
self.closeOnResize = options.closeOnResize;
self.cssScrollBlocked = options.cssScrollBlocked;
self.closeEsc = options.closeEsc;

self.desktop = device.desktop();

self.modifiers = {
active: options.activeClass,
opened: options.openedClass,
beforeOpen: options.beforeOpenClass
};

self.outsideClick();
if ( self._mediaWidth === null || window.innerWidth < self._mediaWidth ) {
self.preparationAnimation();
}
self.toggleMenu();
self.eventsbtnClose();
self.clearStyles();
self.closeNavOnEsc();
self.closeNavMethod();
};

ExtraPopup.prototype.navIsOpened = false;

// overlay append to "overlayAppendTo"
ExtraPopup.prototype.createOverlay = function () {
var self = this,
$overlay = self.$overlay;

$overlay.appendTo(self.overlayAppendTo);

TweenMax.set($overlay, {
autoAlpha: 0,
position: 'fixed',
width: '100%',
height: '100%',
left: 0,
top: 0,
background: '#000',
'z-index': self._overlayIndex,
onComplete: function () {
TweenMax.to($overlay, self._animateSpeedOverlay / 1000, {autoAlpha: self._overlayAlpha});
}
});
};

// toggle overlay
ExtraPopup.prototype.toggleOverlay = function (close) {
var self = this,
$overlay = self.$overlay,
ease = self.ease;

if (close === false) {
TweenMax.to($overlay, self._animateSpeedOverlay / 1000, {
autoAlpha: 0,
ease: ease,
onComplete: function () {
$overlay.remove();
}
});
return false;
}

self.createOverlay();
};

// toggle menu
ExtraPopup.prototype.toggleMenu = function () {
var self = this,
$buttonMenu = self.$btnMenu;

// $buttonMenu.on('mousedown touchstart vmousedown', function (e) {
$buttonMenu.on('click', function (e) {

if (self.navIsOpened) {
self.closeNav();
} else {
self.openNav();
}

e.preventDefault();
e.stopPropagation();
});
};

// events btn close menu
ExtraPopup.prototype.eventsbtnClose = function () {

var self = this;

self.$btnClose.on('click', function (e) {
e.preventDefault();

if ( self.navIsOpened ) {
self.closeNav();
}

e.stopPropagation();
});
};

// click outside menu
ExtraPopup.prototype.outsideClick = function () {
var self = this;

$(document).on('click', function () {
if ( self.navIsOpened ) {
self.closeNav();
}
});

self.$navContainer.on('click', function (e) {
if ( self.navIsOpened ) {
e.stopPropagation();
}
})
};

// close popup on click to "Esc" key
ExtraPopup.prototype.closeNavOnEsc = function () {
var self = this;

$(document).keyup(function(e) {
if (self.navIsOpened && self.closeEsc && e.keyCode === 27) {
self.closeNav();
}
});
};

// close popup (method)
ExtraPopup.prototype.closeNavMethod = function () {
var self = this;

self.$navContainer.on('extraPopupClose', function () {
if (self.navIsOpened) {
self.closeNav();
}
})
};

// open nav
ExtraPopup.prototype.openNav = function() {
// console.log("openNav");

var self = this,
$html = self.$mainContainer,
$navContainer = self.$navContainer,
$buttonMenu = self.$btnMenu,
$buttonClose = self.$btnClose,
_animationSpeed = self._animateSpeedOverlay,
$staggerElement = self.$staggerElement,
ease = self.ease;

var modifiers = self.modifiers;
var classBeforeOpen = modifiers.beforeOpen;
var classAfterOpen = modifiers.opened;

$navContainer.trigger('extraPopupBeforeOpen');
// self.options.extraPopupBeforeOpen(self.$navContainer);

$html.addClass(classBeforeOpen);
$buttonMenu.addClass(modifiers.active);
$buttonClose.addClass(classBeforeOpen);

if(self.cssScrollBlocked){
self.cssScrollFixed();
}

$navContainer.css({
'-webkit-transition-duration': '0s',
'transition-duration': '0s'
});

// animation of stagger
if($staggerElement) {
TweenMax.staggerTo($staggerElement, 0.85, {
autoAlpha: 1,
scale: 1,
y: 0,
yPercent: 0,
xPercent: 0,
ease: ease
}, 0.1);
}

TweenMax.to($navContainer, _animationSpeed / 1000, {
xPercent: 0,
scale: 1,
autoAlpha: 1,
ease: ease,
onComplete: function () {
$html.addClass(classAfterOpen);
$buttonClose.addClass(classAfterOpen);

// if (DESKTOP) {
// 	noScroll();
// }
}
});

if (self.overlayBoolean) {
self.toggleOverlay();
}

self.navIsOpened = true;
};

// close nav
ExtraPopup.prototype.closeNav = function() {
// console.log("closeNav");

var self = this,
$html = self.$mainContainer,
$navContainer = self.$navContainer,
$buttonMenu = self.$btnMenu,
$buttonClose = self.$btnClose,
$staggerElement = self.$staggerElement,
_animationSpeed = self._animateSpeedOverlay,
_mediaWidth = self._mediaWidth,
_animationType = self._animationType,
ease = self.ease,
alpha = self.alpha;

var modifiers = self.modifiers;
var classAfterOpen = modifiers.opened;
var classBeforeOpen = modifiers.beforeOpen;

$html.removeClass(classAfterOpen);
$html.removeClass(classBeforeOpen);
$buttonMenu.removeClass(modifiers.active);
$buttonClose.removeClass(classAfterOpen);
$buttonClose.removeClass(classBeforeOpen);

if (self.overlayBoolean) {
self.toggleOverlay(false);
}

var duration = _animationSpeed / 1000;

// animation of stagger
if($staggerElement) {
TweenMax.staggerTo($staggerElement, 0.85, {
autoAlpha: alpha,
xPercent: -100
}, 0.1);
}

if (_animationType === 'ltr') {
TweenMax.to($navContainer, duration, {
xPercent: -100,
ease: ease,
onComplete: function () {
if (_mediaWidth === null || window.innerWidth < _mediaWidth) {
self.preparationAnimation();
}

TweenMax.set($navContainer, {
autoAlpha: alpha
});

// if (DESKTOP) {
// 	canScroll();
// }

if(self.cssScrollBlocked){
self.cssScrollUnfixed();
}
}
});

} else if (_animationType === 'rtl') {
TweenMax.to($navContainer, duration, {
xPercent: 100,
ease: ease,
onComplete: function () {
if (_mediaWidth === null || window.innerWidth < _mediaWidth) {
self.preparationAnimation();
}

TweenMax.set($navContainer, {
autoAlpha: alpha
});

// if (DESKTOP) {
// 	canScroll();
// }

if(self.cssScrollBlocked){
self.cssScrollUnfixed();
}
}
});

} else if (_animationType === 'surface') {
TweenMax.to($navContainer, duration, {
scale: self._animationScale,
autoAlpha: alpha,
ease: ease,
onComplete: function () {
if (_mediaWidth === null || window.innerWidth < _mediaWidth) {
self.preparationAnimation();
}

// if (DESKTOP) {
// 	canScroll();
// }

if(self.cssScrollBlocked){
self.cssScrollUnfixed();
}
}
});

} else {
console.error('Type animation "' + _animationType + '" is wrong!');
return;
}

self.navIsOpened = false;
};

// preparation element before animation
ExtraPopup.prototype.preparationAnimation = function() {
var self = this;

var $navContainer = self.$navContainer,
$staggerElement = self.$staggerElement,
_animationType = self._animationType,
alpha = self.alpha;

// console.log('preparationAnimation: ', $navContainer);

// animation of stagger
if($staggerElement) {
TweenMax.set($staggerElement, {
autoAlpha: alpha,
xPercent: -100
});
}

if (_animationType === 'ltr') {
TweenMax.set($navContainer, {
xPercent: -100,
autoAlpha: alpha,
onComplete: function () {
$navContainer.show(0);
}
});

} else if (_animationType === 'rtl') {
TweenMax.set($navContainer, {
xPercent: 100,
autoAlpha: alpha,
onComplete: function () {
$navContainer.show(0);
}
});

} else if (_animationType === 'surface') {
TweenMax.set($navContainer, {
scale: self._animationScale,
autoAlpha: alpha,
onComplete: function () {
$navContainer.show(0);
}
});

} else {
console.error('Type animation "' + _animationType + '" is wrong!');
}
};

ExtraPopup.prototype.cssScrollFixed = function() {
$('html').addClass('css-scroll-fixed');
$(document).trigger('extraPopupScrollFixed');
};

ExtraPopup.prototype.cssScrollUnfixed = function() {
$('html').removeClass('css-scroll-fixed');
$(document).trigger('extraPopupScrollUnfixed');
};

// clearing inline styles
ExtraPopup.prototype.clearStyles = function() {
var self = this,
$btnMenu = self.$btnMenu,
$navContainer = self.$navContainer,
$staggerElement = self.$staggerElement;

//clear on horizontal resize
if (self.closeOnResize === true) {

$(window).on('resizeByWidth', function () {
if (self.navIsOpened) {
if (!$btnMenu.is(':visible')) {
$navContainer.attr('style', '');
$staggerElement.attr('style', '');
self.closeNav();
} else {
self.closeNav();
}
}
});

}
};

window.ExtraPopup = ExtraPopup;

}(jQuery));

function mainNavigationInit(){
var navShutterClass = '.nav';
var $navShutter = $(navShutterClass);

if($navShutter.length){

new ExtraPopup({
navContainer: navShutterClass,
navMenu: '.nav-list',
btnMenu: '.btn-menu',
btnClose: '.btn-menu-close',
// staggerElement: '.nav-list > li',
overlayClass: 'nav-overlay',
overlayAppendTo: '.header',
closeOnResize: false,
animationSpeed: 300,
overlayAlpha: 0.35,
overlayIndex: 98,
cssScrollBlocked: true,
openedClass: 'nav-opened',
beforeOpenClass: 'nav-opened-start',
ease: 'Power2.easeInOut'
// ease: 'Power0.easeNone'
});
}
}
/*main navigation end*/

/**
* add class on scroll to top
* */
function headerShow(){
// external js:
// 1) resizeByWidth (resize only width);

var $page = $('html'),
minScrollTop = 100;

var previousScrollTop = $(window).scrollTop();

$(window).on('load scroll resizeByWidth', function () {
var currentScrollTop = $(window).scrollTop();

$page.toggleClass('page-is-scrolled', (currentScrollTop >= minScrollTop));

var showHeaderPanel = currentScrollTop < previousScrollTop || currentScrollTop <= minScrollTop;
$page.toggleClass('header-show', showHeaderPanel);
$page.toggleClass('header-hide', !showHeaderPanel);

previousScrollTop = currentScrollTop;
});
}
/*add class on scroll to top end*/

/**
* !sliders
* */
function slidersInit() {
//banners slider
var $bannerSliders = $('.banners-slider');

if($bannerSliders.length) {
$bannerSliders.each(function() {
var $currentSlider = $(this);

$currentSlider.slick({
slidesToShow: 1,
slidesToScroll: 1,
infinite: true,
dots: true,
arrows: false,
adaptiveHeight: false,
responsive: [
{
breakpoint: 980,
settings: {
slidesToShow: 4,
slidesToScroll: 4,
adaptiveHeight: false
}
}, {
breakpoint: 900,
settings: {
slidesToShow: 3,
slidesToScroll: 3
}
}, {
breakpoint: 640,
settings: {
slidesToShow: 2,
slidesToScroll: 2
}
}, {
breakpoint: 480,
settings: {
slidesToShow: 1,
slidesToScroll: 1
}
}
]
});
});
}

//promo slider
var $promoSliders = $('.promo-slider');

if($promoSliders.length) {
$promoSliders.each(function() {
var $currentSlider = $(this);

$currentSlider.slick({
slidesToShow: 1,
slidesToScroll: 1,
infinite: true,
dots: true,
arrows: true
});
});
}

//shares slider
var $sharesSliders = $('.shares-slider');

if($sharesSliders.length) {
$sharesSliders.each(function() {
var $currentSlider = $(this);

$currentSlider.slick({
slidesToShow: 3,
slidesToScroll: 3,
infinite: true,
dots: true,
arrows: true,
responsive: [
{
breakpoint: 1280,
settings: {
slidesToShow: 2,
slidesToScroll: 2
}
},
{
breakpoint: 980,
settings: {
slidesToShow: 3,
slidesToScroll: 3
}
},
{
breakpoint: 640,
settings: {
arrows: false,
dots: true,
slidesToShow: 2,
centerPadding: '30px',
centerMode: true
// variableWidth: true
}
},
{
breakpoint: 520,
settings: {
arrows: false,
slidesToShow: 1,
centerPadding: '40px',
centerMode: true
// variableWidth: true
}
}
]
});
});
}
}
/*sliders end*/

/**
* popup initial
* */
function popupInitial(){
$('.popup-gmaps').magnificPopup({
disableOn: 700,
type: 'iframe',
mainClass: 'mfp-fade',
removalDelay: 160,
preloader: false,
tClose: 'Закрыть (Esc)',
tLoading: 'Загрузка...',

fixedContentPos: true,
callbacks:{
beforeClose: function() {
$('.mfp-opened').removeClass('mfp-opened');
}
}
});

$('.popup-with-form').magnificPopup({
type: 'inline',
preloader: false,
focus: '#name',
mainClass: 'mfp-fade',
fixedContentPos: true,

// When elemened is focused, some mobile browsers in some cases zoom in
// It looks not nice, so we disable it:
callbacks: {
beforeOpen: function() {
if($(window).width() < 700) {
this.st.focus = false;
} else {
this.st.focus = '#name';
}
}
}
});

$('.image-popup-vertical-fit').magnificPopup({
type: 'image',
closeOnContentClick: true,
closeBtnInside: true,
fixedContentPos: true,
mainClass: 'mfp-with-zoom', // class to remove default margin from left and right side
image: {
verticalFit: true
},
zoom: {
enabled: true,
duration: 300 // don't foget to change the duration also in CSS
}
});
}
/*popup initial end*/

/**!
* accordion
* */
(function ($) {
var JsAccordion = function (settings) {
var options = $.extend({
accordionContainer: null,
accordionItem: null,
accordionContent: null,
accordionHeader: 'h3',
accordionWrap: null,
indexInit: 0, // if "false", all accordion are closed
animateSpeed: 300,
scrollToTop: false, // if true, scroll to current accordion;
clickOutside: false // if true, close current accordion's content on click outside accordion;
}, settings || {});

this.options = options;
var container = $(options.accordionContainer);
this.$accordionContainer = container;
this.$accordionItem = $(options.accordionItem, container);
this.$accordionHeader = $(options.accordionHeader, container);
this.$accordionContent = options.accordionContent ?
$(options.accordionContent, container) :
this.$accordionHeader.next();

this.scrollToTop = options.scrollToTop;
this.clickOutside = options.clickOutside;
this._indexInit = options.indexInit;
this._animateSpeed = options.animateSpeed;

this.modifiers = {
activeAccordion: 'js-accordion_active',
activeHeader: 'js-accordion__header_active',
activeContent: 'js-accordion__content_active'
};

this.bindEvents();
this.activeAccordion();
};

// it takes values current index of accordion's content
JsAccordion.prototype.indexActive = 0;

// it takes values false or current index of accordion's content
JsAccordion.prototype.activeState = false;

JsAccordion.prototype.bindEvents = function () {
var self = this,
$accordionContent = self.$accordionContent,
animateSpeed = self._animateSpeed;

self.$accordionHeader.on('click', function (e) {
e.preventDefault();

var $currentItem = $(this).closest(self.$accordionItem),
$currentItemContent = $currentItem.find($accordionContent),
currentIndex = $currentItem.index();

if($accordionContent.is(':animated')) return false;

self.indexActive = currentIndex;

if(self.activeState === currentIndex){
self.closeAccordionContent();
return;
}

self.closeAccordionContent();

$currentItemContent.slideToggle(animateSpeed, function () {
self.scrollPosition();
});

e.stopPropagation();
});

$(document).click(function () {
if (self.clickOutside) {
self.closeAccordionContent();
}
});

$accordionContent.on('click', function(e){
e.stopPropagation();
});
};

// show current accordion's content
JsAccordion.prototype.activeAccordion = function () {
var self = this;
var indexInit = self._indexInit;

if ( indexInit === false ) return false;

self.$accordionItem.eq(indexInit).find(self.$accordionContent).fadeIn('slow');

self.indexActive = indexInit;
self.toggleActiveClass();
};

// close accordion's content
JsAccordion.prototype.closeAccordionContent = function () {
var self = this;
self.$accordionContent.slideUp(self._animateSpeed);
self.toggleActiveClass();
};

// change active class
JsAccordion.prototype.toggleActiveClass = function () {
var self = this,
activeAccordion = self.modifiers.activeAccordion,
activeHeader = self.modifiers.activeHeader,
activeContent = self.modifiers.activeContent,
$accordionItem = self.$accordionItem,
$accordionHeader = self.$accordionHeader,
$accordionContent = self.$accordionContent,
indexActive = self.indexActive,
activeState = self.activeState;

$accordionItem.removeClass(activeAccordion);
$accordionHeader.removeClass(activeHeader);
$accordionContent.removeClass(activeContent);

if (indexActive !== activeState) {
$accordionItem.eq(indexActive).addClass(activeAccordion);
$accordionHeader.eq(indexActive).addClass(activeHeader);
$accordionContent.eq(indexActive).addClass(activeContent);
self.activeState = indexActive;

// console.log("indexActive1: ", self.indexActive);
// console.log("activeState1: ", self.activeState);
return false;
}

self.activeState = false;

// console.log("indexActive2: ", self.indexActive);
// console.log("activeState2: ", self.activeState);
};

JsAccordion.prototype.scrollPosition = function () {
var self = this;
if (self.scrollToTop) {
$('html, body').animate({ scrollTop: self.$accordionItem.eq(self.indexActive).offset().top - $('.header').outerHeight() }, self._animateSpeed);
}
};

window.JsAccordion = JsAccordion;
}(jQuery));
/*accordion end*/

/**
* default accordion
* */
function jsAccordion() {
// accordion default
var $accordion = $('.accordion-container');
if($accordion.length){
$accordion.each(function () {
new JsAccordion({
accordionContainer: $(this),
accordionItem: '.accordion-content',
accordionHeader: '.accordion-hand',
accordionContent: '.accordion-panel',
indexInit: false,
animateSpeed: 300,
scrollToTop: true
});
})
}
}
/*default accordion end*/

/**
* multi accordion
* */
(function ($) {
var MultiAccordion = function (settings) {
var options = $.extend({
accordionContainer: null,
accordionItem: 'li',
accordionCall: 'a',
collapsibleElement: null,
collapsibleAll: false,
animateSpeed: 300,
resizeCollapsible: false,
initialPoint: null
}, settings || {});

this.options = options;
var container = $(options.accordionContainer);
this.$accordionContainer = container; //блок с аккордеоном
this.$accordionItem = $(options.accordionItem, container); //непосредственный родитель сворачиваемого элемента
this.$accordionCall = $(options.accordionCall, container); //элемент, по которому производим клик
this.$collapsibleElement = $(options.collapsibleElement); //элемент, который сворачивается/разворачивается
this._collapsibleAll = options.collapsibleAll;
this._animateSpeed = options.animateSpeed;
this._resizeCollapsible = options.resizeCollapsible;//флаг, сворачивание всех открытых аккордеонов при ресайзе
this.initialPoint = options.initialPoint;//флаг, сворачивание всех открытых аккордеонов при ресайзе

this.modifiers = {
active: 'opened',
current: 'active'
};

this.bindEvents();
this.totalCollapsibleOnResize();

};

MultiAccordion.prototype.totalCollapsibleOnResize = function () {
var self = this;
$(window).on('resize', function () {
if(self._resizeCollapsible){
self.$collapsibleElement.slideUp(self._animateSpeed, function () {
self.$accordionContainer.trigger('accordionChange');
});
self.$accordionItem.removeClass(self.modifiers.active);
}
});
};

MultiAccordion.prototype.bindEvents = function () {
var self = this,
modifiers = this.modifiers,
animateSpeed = this._animateSpeed,
$accordionContainer = this.$accordionContainer,
$anyAccordionItem = this.$accordionItem,
$collapsibleElement = this.$collapsibleElement,
initialPoint = this.initialPoint;

$accordionContainer.on('click', self.options.accordionCall, function (e) {
if (window.innerWidth >= initialPoint ) return;

var current = $(this);
var currentAccordionItem = current.closest($anyAccordionItem);

if (!currentAccordionItem.has($collapsibleElement).length) return;

e.preventDefault();

if (current.parent().prop("tagName") != currentAccordionItem.prop("tagName")) {
current = current.parent();
}

if (current.siblings($collapsibleElement).is(':visible')){
currentAccordionItem.removeClass(modifiers.active).find($collapsibleElement).slideUp(animateSpeed, function () {
self.$accordionContainer.trigger('accordionChange');
});
// currentAccordionItem.removeClass(modifiers.current);
currentAccordionItem
.find($anyAccordionItem)
.removeClass(modifiers.active);
// .removeClass(modifiers.current);
return;
}


if (self._collapsibleAll){
var siblingContainers = $($accordionContainer).not(current.closest($accordionContainer));
siblingContainers.find($collapsibleElement).slideUp(animateSpeed, function () {
self.$accordionContainer.trigger('accordionChange');
});
siblingContainers
.find($anyAccordionItem)
.removeClass(modifiers.active);
// .removeClass(modifiers.current);
}

currentAccordionItem
.siblings()
.removeClass(modifiers.active)
.find($collapsibleElement)
.slideUp(animateSpeed, function () {
self.$accordionContainer.trigger('accordionChange');
});
// currentAccordionItem.siblings().removeClass(modifiers.current);
currentAccordionItem.siblings()
.find($anyAccordionItem)
.removeClass(modifiers.active);
// .removeClass(modifiers.current);

currentAccordionItem.addClass(modifiers.active);
current.siblings($collapsibleElement).slideDown(animateSpeed, function () {
self.$accordionContainer.trigger('accordionChange');
});
})
};

window.MultiAccordion = MultiAccordion;
}(jQuery));

function menuAccordionInit() {
if($('.nav-list').length){
new MultiAccordion({
accordionContainer: '.nav-list',
collapsibleElement: '.nav-drop, .nav-sub-drop',
animateSpeed: 200,
initialPoint: 1280
});
}
}
/*multi accordion end*/

/**
* file input
* */
function fileInput() {
$('.upload-file').each(function () {
$(this).filer({
showThumbs: true,
addMore: true,
allowDuplicates: false,
limit: 1
});
});
}
/*file input end end*/

/**
* init Masks
* */
function initMask() {
$(".date-mask").inputmask("99.99.9999",{ "placeholder": "__.__.____" });
}
/*init Masks end end*/

/**
* tab switcher
* */
function tabSwitcher() {
// external js:
// 1) TweetMax VERSION: 1.19.0 (widgets.js);
// 2) resizeByWidth (resize only width);

var $main = $('.main');

var $container = $('.js-tab-container');

if ( !$container.length ) return false;

if($main.length){
var $anchor = $('.js-tab-anchor'),
$content = $('.js-tab-content'),
activeClass = 'active',
animationSpeed = 0,
animationHeightSpeed = 0.08;

$.each($main, function () {
var $this = $(this),
$thisAnchor = $this.find($anchor),
$thisContainer = $this.find($container),
$thisContent = $this.find($content),
initialDataAtr = $thisAnchor.eq(0).data('for'),
activeDataAtr = false;

// prepare traffic content
function prepareTrafficContent() {
$thisContainer.css({
'display': 'block',
'position': 'relative',
'overflow': 'hidden'
});

$thisContent.css({
'display': 'block',
'position': 'absolute',
'left': 0,
'right': 0,
'width': '100%',
'z-index': -1
});

switchContent();
}

prepareTrafficContent();

// toggle content
$thisAnchor.on('click', function (e) {
e.preventDefault();

var $cur = $(this),
dataFor = $cur.data('for');

if (activeDataAtr === dataFor) return false;

initialDataAtr = dataFor;

switchContent();
});

// switch content
function switchContent() {
toggleContent();
changeHeightContainer();
toggleActiveClass();
}

// show active content and hide other
function toggleContent() {

$thisContainer.css('height', $thisContainer.outerHeight());

$thisContent.css({
'position': 'absolute',
'left': 0,
'right': 0
});

TweenMax.set($thisContent, {
autoAlpha: 0,
'z-index': -1
});

var $initialContent = $thisContent.filter('[data-id="' + initialDataAtr + '"]');

$initialContent.css('z-index', 2);

TweenMax.to($initialContent, animationSpeed, {
autoAlpha: 1
});
}

// change container's height
function changeHeightContainer() {
var $initialContent = $thisContent.filter('[data-id="' + initialDataAtr + '"]');

TweenMax.to($thisContainer, animationHeightSpeed, {
'height': $initialContent.outerHeight(),
onComplete: function () {

$thisContainer.css('height', 'auto');

$initialContent.css({
'position': 'relative',
'left': 'auto',
'right': 'auto'
});
}
});
}

// toggle class active
function toggleActiveClass(){
$thisAnchor.removeClass(activeClass);
$thisContent.removeClass(activeClass);

// toggleStateThumb();

if (initialDataAtr !== activeDataAtr) {

activeDataAtr = initialDataAtr;

$thisAnchor.filter('[data-for="' + initialDataAtr + '"]').addClass(activeClass);
$thisContent.filter('[data-id="' + initialDataAtr + '"]').addClass(activeClass);

return false;
}

activeDataAtr = false;
}
});
}
}
/* tab switcher end */

/**
* filter job
* */
function filterJob() {
$('.job-selects').on('change', 'select', function () {

var $this = $(this),
name = $this.attr('name'),
classNoItem = 'filter-no-item';

var tags = {};

$this.closest('[data-id]').find('select').each(function () {
tags [$(this).attr('name')] = $(this).val();
});

tags [name] = $this.val();

var $filterItem = $this.closest('.js-tab-content').find('.accordion-content');

var $noItemTemplate = $('<div />', {
class: classNoItem,
text: 'Извините, подходящих вакансий не найдено'
});

// console.log("tags: ", tags);
var dataFilters = concatObject(tags);
// console.log("dataFilters: ", dataFilters);

$filterItem.parent().find('.'+ classNoItem).remove();
$filterItem.show(0);

if (dataFilters) {

$filterItem.hide(0);
$filterItem.filter(dataFilters).show(0);

if (!$filterItem.is(':visible')) {
$filterItem.parent().append($noItemTemplate.clone());
}
}
});

function concatObject(obj) {
var arr = [];

for ( var prop in obj ) {
var thisKey = prop,
thisProp = obj[ thisKey ];

if (thisProp == 0) continue;

arr.push('[data-property-' + thisKey + '*="' + thisProp + '"]');
}

return arr.join('');
}
}
/*filter job end*/

/**!
* equal height
* */
function equalHeightInit() {
$(window).load(function () {
// news list
var $newsList = $('.news-list');
if ($newsList.length) {
$('.news-item__text', $newsList).equalHeight({
useParent: true,
parent: $newsList,
resize: true
});
}

var $productsList = $('.products-list');

if ($productsList.length) {
$productsList.children().matchHeight({
byRow: true,
property: 'height',
target: null,
remove: false
});
}
})
}
/*equal height end*/

/**
* init js drop
* */
function initJsDrops(){
var jsDropWrappers = '.js-compactor-clone';
var $jsDropWrapper = $(jsDropWrappers);

$jsDropWrapper.on('click', '.js-compactor-btn', function (e) {
e.preventDefault();

var $currentJsDropWrapper = $(this).closest(jsDropWrappers);
var currentWasOpened = $currentJsDropWrapper.hasClass('show-drop');

$jsDropWrapper.removeClass('show-drop');
if (!currentWasOpened) {
$currentJsDropWrapper.addClass('show-drop');

if($currentJsDropWrapper.closest('.header').length){
$('html').removeClass('position');
}
}
return false;
});

$jsDropWrapper.on('click', '.location-filter-drop', function (e) {
e.stopPropagation();
// return false;
});

$(document).click(function () {
$jsDropWrapper.removeClass('show-drop');
});
}
/*init js drop end*/

/**
* compactor
* */
function compactor() {
var $main = $('.location-filter');

if ($main.length) {

var $itemsContainer = $('.location-filter-list');

$(window).load(function () {
$itemsContainer.contents().clone().appendTo('#location-filter-clone');
});

var $items = $itemsContainer.find('.location-filter-item');
var minWidthItem = 165;
var itemsContainerWidth, lengthAllItems, actualTotalWidth, hideItemsLength;

var $cloneContainer = $('.js-compactor-clone');
var $moreBtnTextMain = $cloneContainer.find('.js-compactor-btn-main');
var $moreBtnTextAlt = $cloneContainer.find('.js-compactor-btn-alt');

$(window).on('load resizeByWidth', function () {
if (window.innerWidth < 640) {
minWidthItem = 155;
}

itemsContainerWidth = ($cloneContainer.is(':visible')) ? $itemsContainer.width() : $itemsContainer.width() - $cloneContainer.outerWidth();
lengthAllItems = $items.length;

actualTotalWidth = lengthAllItems * minWidthItem;
hideItemsLength = ( itemsContainerWidth > actualTotalWidth ) ? 0 : Math.abs(Math.ceil((actualTotalWidth - itemsContainerWidth)/minWidthItem));

// set the width of the visible items (in percent)
$items.css('width', (1/(lengthAllItems - hideItemsLength)*100)+'%');
// $cloneContainer.css('width', newWidthItem);

// if(lengthAllItems == hideItemsLength + 1){
if(lengthAllItems == hideItemsLength){
$moreBtnTextAlt.attr('style','display: inline-block;');
$moreBtnTextMain.attr('style','display: none;');
} else {
$moreBtnTextAlt.attr('style','display: none;');
$moreBtnTextMain.attr('style','display: inline-block;');
}

// $main.toggleClass('show-clone', lengthAllItems * minWidthItem > itemsContainerWidth);
$main.toggleClass('show-btn-more', hideItemsLength > 0);
$main.toggleClass('hide-all-items', hideItemsLength === lengthAllItems);

$('.location-filter-item').removeClass('compactor-cloned');

for ( var i = 0; i <= hideItemsLength; i++ ) {
// var indexCloned = lengthAllItems - i - 1;
var indexCloned = lengthAllItems - i;
$($items[indexCloned]).addClass('compactor-cloned');
$($cloneContainer.find('.location-filter-item')[indexCloned]).addClass('compactor-cloned');
}
});

}
}
/*compactor end*/

/**!
* shops location
* */
function shopsLocation() {
if ( !$('.shops').length ) return false;

var myMap,
myClusterer,
myPlacemark = [],
mapId = "#shops-map",
$mapId = $(mapId),
currentCity = "minsk",
baseImageURL = '/local/templates/.default/assets/img/',
$selectCity = $('#selectCity'),
urlShops = $selectCity.data('url'),
fullscreenControl;

/*initial map*/
if ( $mapId.length ) {
ymaps.ready(init);

function init(){
/*styling cluster icons*/
var clusterIcons = [
{
href: baseImageURL + 'map-cluster-2x.png',
size: [46, 46],
offset: [-23, -23]
},
{
href: baseImageURL + 'map-cluster-2x.png',
size: [60, 60],
offset: [-30, -30],
shape: {
type: 'Circle',
coordinates: [0, 0],
radius: 30
}
}],
clusterNumbers = [20],
MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
'<div style="color: #FFFFFF; font-weight: normal; font-family: "PT Sans Serif", sans-serif;">{{ properties.geoObjects.length }}</div>'
);

/*create new cluster object*/
myClusterer = new ymaps.Clusterer({
clusterIcons: clusterIcons,
clusterNumbers: clusterNumbers,
clusterIconContentLayout: MyIconContentLayout,
maxZoom: 11
});

/*create new map object*/
myMap = new ymaps.Map (mapId.substring(1), {
center: [51.9071097,27.4923474],
zoom: 11,
// controls: ['fullscreenControl']
controls: []
});

/*add zoom control button*/
var zoomControl = new ymaps.control.ZoomControl({
options: {
size: "small",
position: {right: 10, bottom: 50}
}
});
myMap.controls.add(zoomControl);

fullscreenControl = new ymaps.control.FullscreenControl();
myMap.controls.add(fullscreenControl);

/*add geolocation control button*/
// var geolocationControl = new ymaps.control.GeolocationControl({
// 	options: {
// 		noPlacemark: true
// 	}
// });
//
// var myLocationPlacemark;
//
// geolocationControl.events.add('locationchange', function (event) {
// 	var position = event.get('position');
//
// 	setBoundsMap();
//
// 	myMap.geoObjects.remove(myLocationPlacemark);
//
// 	myLocationPlacemark = new ymaps.Placemark(
// 		position
// 	);
//
// 	myMap.geoObjects.add(myLocationPlacemark);
// });
// myMap.controls.add(geolocationControl);

/*behaviors setting map*/
myMap.behaviors.disable('scrollZoom');

/*select current city*/
selectCurrentCity();
}
} else {
/*select current city*/
selectCurrentCity();
}

/*select current city*/
function selectCurrentCity() {
var $selectShops = $("#selectCity");

$selectShops.find("option[value='" + currentCity + "']").prop('selected', true);

/*refresh custom select*/
if (DESKTOP) {
$selectShops.multiselect('refresh');
}

selectCity(currentCity);
}

/*custom select city*/
$selectCity.on('change', function(){
var value = $(this).val();

selectCity(value);
});

/*select city*/
function selectCity(value) {
if ( value != 0 ) {

/*change current city flag*/
currentCity = value;

/*clear filter tags*/
clearFilterTags();
searchShopsByTag();

var jsonResult = [];

$.get(urlShops + "/" + value + ".json", {ajax: '1', action: 'json'}, function (data) {
addCountLoader();

jsonResult = data;
reDrawNewCitiesMarks(jsonResult);

}, "json").done(function () {
removeCountLoader();
});

$('.shops-aside-group').hide(0, function () {
$('.shops-aside-holder').css('overflow', 'hidden');
});

$('[data-item-group = ' + value + ']').show(0, function () {
$('.shops-aside-holder').css('overflow', 'auto');
});

}
}

var $noItemTemplate = $('<div />', {
class: 'filter-no-item',
text: 'Извините, магазинов с выбранными параметрами не найдено'
});

/*create and push new placemarks*/
function reDrawNewCitiesMarks ( jsonResult ) {

/*remove all placemark*/
if (myClusterer) {
myClusterer.removeAll();
}

/*hide all item on shops list*/
$('.shops-item','.shops-aside-group').hide(0);

/*toggle "no item" message*/
$('.filter-no-item').remove();

/*count search shops*/
countShops(jsonResult.length);

if (!jsonResult.length) {
$('.shops').append($noItemTemplate.clone());

return false;
}

/*create geo objects Array*/
var myGeoObjects = [];

$.each( jsonResult, function(i, item) {

var coordStr = item.coord,
id = item.id;

/*toggle item on shops list*/
$('[data-location-index = ' + id + ']').show(0);

/*building tags list*/
var tags = function () {
if (item.tags.length) {
var j, tag, result = '';
for ( j = 0; j < item.tags.length ; j++) {
var currentTag = item.tags[j];
tag = '<span style="background-image: url(' + currentTag.tags_url + ');"><i>' + currentTag.tags_title + '</i></span>';
result += tag;
}
return result;
}
};

if ( $mapId.length ) {

/*create balloon content*/
var balloonContent = '' +
'<div class="map-popup">' +
    '<div class="map-popup__title">' + item.name + '</div>' +
    '<div class="map-popup__list">' +
        (item.work_time ? '<div class="map-popup__row work-time"><i class="depict-time"></i>' + item.work_time + '</div>' : '') +
        (item.phones ? '<div class="map-popup__row"><i class="depict-phone"></i>' + item.phones + '</div>' : '') +
        '<div class="map-popup__row">' +
            (tags() ? '<div class="map-popup__shops-tags">' + tags() + '</div>' : '') +
            '</div>' +
        '<div class="map-popup__row"><a href="#" class="more" data-more-id="' + id + '">Подробнее</a></div>' +
        '</div>' +
    '</div>';

/*add placemarks to the map*/
if ( coordStr !== null ) {
var coordArray = coordStr.split(', ');

myPlacemark[id] = new ymaps.Placemark([coordArray[0], coordArray[1]], {
balloonContentBody: balloonContent,
hintContent: item.name
}, {
iconLayout: 'default#image',
iconImageHref: baseImageURL + 'depict-map-2x.png',
iconImageSize: [45, 61],
iconImageOffset: [-22, -59],
hideIconOnBalloonOpen: false,
balloonOffset: [0, -61],
balloonPosition: ['center', 'top']
});

myGeoObjects[id] = new ymaps.GeoObject({});

myClusterer.add(myPlacemark[id]);
}

}
});

if ( $mapId.length ) {
myMap.geoObjects.add(myClusterer);

setBoundsMap();
}

}

function setBoundsMap() {
myMap.setBounds(myClusterer.getBounds(), {checkZoomRange: false}).then(function () {
if (myMap.getZoom() > 11) myMap.setZoom(11);
});
}

/*show more information*/
function showMoreInfo() {
$('body').on('click', 'ymaps .more', function (e) {
e.preventDefault();

fullscreenControl.exitFullscreen();

var index = $(this).data('more-id');

var $currentItem = $('.shops-aside [data-location-index="' + index + '"]');
if (!$currentItem.hasClass('item-active')) {
$currentItem.find('.shops-item__title a').trigger('click');
}
})
}

showMoreInfo();

/*filter tags*/
$('.location-filter-wrap').on('change', ':checkbox', function () {
searchShopsByTag();
});

function searchShopsByTag() {
var value = currentCity;
var dataTagArr = [];
var newResult = [];

var $checkbox = $('.location-filter-wrap input:checked');

$.each($checkbox, function () {
dataTagArr.push($(this).val());
});

$.get(urlShops + "/" + value + ".json", {ajax: '1', action: 'json'}, function (data) {
addCountLoader();

var jsonResult = data;

$.each(jsonResult, function (i, iItem) {

var countEqual = 0;

// var countEqualFlag = countEqual + iItem.tags.length;

$.each(iItem.tags, function (j, jItem) {

// console.log("jItem: (" + i + "." + j + ") ", jItem.tags_label);

$.each(dataTagArr, function (l, lItem) {

// console.log("tag: ", lItem);

if (jItem.tags_label === lItem) {
countEqual++;
return false;
}

// countEqualFlag--;

});

// if (countEqualFlag === countEqual) return false;

// console.log('============STOP===========');

});

// console.log("countEqual == dataTagArr.length: ", countEqual + " == " + dataTagArr.length);

if (countEqual === dataTagArr.length) {
// console.log("i: ", i);
createNewResult(i);
}


// if (countEqualFlag === countEqual) return false;


// console.log("iT: ", iItem);
// console.log("iItem.tags: ", iItem.tags);
});

function createNewResult(index) {
newResult.push(jsonResult[index]);
}

// console.log("newResult: ", newResult);

reDrawNewCitiesMarks(newResult);

}, "json").done(function () {
removeCountLoader();
});
}

/*event on click shops list*/
var moveFlag;
$('.to-map').on('click', 'a', function (e) {
e.preventDefault();

if (window.innerWidth > 1279) {
return;
}

var $page = $('html, body');
var index = $(this).closest('.shops-item').data('location-index');

if (window.innerWidth < 980) {

if (!$page.is(':animated')) {
$page.stop().animate({scrollTop: $mapId.offset().top - $('.header').outerHeight()}, 300);
}

}

if (moveFlag === index) return false;
moveFlag = index;

var coord = myPlacemark[index].geometry.getCoordinates();

myMap.setCenter(coord, 16, {
duration: 100,
checkZoomRange: true
}).then(function () {
myPlacemark[index].balloon.open();
});
});

$('.shops-item__title').on('click', 'a', function (e) {
if (window.innerWidth < 1280) {
return;
}

e.preventDefault();

var index = $(this).closest('.shops-item').data('location-index');

if (moveFlag === index) return false;
moveFlag = index;

var coord = myPlacemark[index].geometry.getCoordinates();

myMap.setCenter(coord, 16, {
duration: 100,
checkZoomRange: true
}).then(function () {
myPlacemark[index].balloon.open();
});
});

/*add count loader*/
function addCountLoader() {
var countLoader = $('<div />', {
class: 'count-loader'
});

$('.js-shops-count').append(countLoader.clone());
$('.shops-aside-frame').append(countLoader.clone());
}

/*remove count loader*/
function removeCountLoader() {
var $countLoader = $('.count-loader');
$countLoader.fadeOut(700, function () {
$countLoader.remove();
});
}

/*count shops*/
function countShops(value) {
$('.shops-count__value', '.js-shops-count').text(value);
}

/*events clear filter button*/
function eventsClearFilterButton() {

var $filters = $('.location-filter');

if ($filters.length) {

$filters.on('change', 'input', function () {
clearBtnState();
});

// clear button event
$('.btn-clear-form').on('click', function (e) {

e.preventDefault();

clearFilterTags();
searchShopsByTag();

});

}
}

eventsClearFilterButton();
/*events clear filter button end*/

/* clear button state */
function clearBtnState() {
setTimeout(function () {
$('.clear-form').toggleClass('btn-active', !!$('.location-filter').find(':checked').length);
}, 300);
}
/*clear button state end*/

/*clear filter tags*/
function clearFilterTags() {
$('.location-filter-wrap').find(':checked').prop("checked", false);
clearBtnState();
}
/*clear filter tags end*/
}
/*shops map end*/

/**
* shops accordion
* */
function shopsAccordion() {
var $container = $('.shops-item');

if ($container.length) {

var $page = $('html,body'),
$hand = $('.shops-item__title a'),
$content = $('.shops-item__extend'),
$scrollContainer = $( ".shops-aside-holder" ),
prevPosition = 0;

$scrollContainer.on('scroll', function () {
prevPosition = $scrollContainer.scrollTop();
});

$hand.on('click', function (e) {
e.preventDefault();
var duration = 'fast';

$content.slideUp(duration);

var $currentHand = $(this);
var $currentItem = $currentHand.closest($container);

if ( $currentHand.hasClass('active') ) {

$hand.removeClass('active');
$container.removeClass('item-active');

return false;

}

$hand.removeClass('active');
$container.removeClass('item-active');

$currentHand
.addClass('active')
.closest($container)
.addClass('item-active')
.find($content)
.stop()
.slideDown(duration, function () {
if (window.innerWidth > 979) {

var currentPosition = $currentItem.position().top + prevPosition;

if (!$scrollContainer.is(':animated') && currentPosition !== 0) {
$scrollContainer.stop().animate({scrollTop: currentPosition}, duration, function () {
prevPosition = currentPosition;
});
}

} else {

if (!$page.is(':animated')) {
$page.stop().animate({scrollTop: $currentItem.offset().top - $('.header').outerHeight()}, duration);
}

}
});
})
}
}
/*shops accordion*/

/**
* add shadow tape
* */
function addShadowTape() {
var shadowTop = $('.js-shadow-tape-top');

$('.shops-aside-holder').scroll(function () {
if ( $(this).scrollTop() > 0 ) {
shadowTop.stop().fadeIn();
} else {
shadowTop.stop().fadeOut();
}
});
}
/*add shadow tape end*/

/**
* toggle view shops
* */
function toggleViewShops() {
var $switcherHand = $('.shops-view-switcher a');

if ( $switcherHand.length ) {

var $container = $('.shops');
var activeHand = 'active';
var activeContainer = 'view-shops-active';

$switcherHand.on('click', function (e) {
e.preventDefault();

var $this = $(this);

if ( $this.hasClass(activeHand) ) return false;

$switcherHand.removeClass(activeHand);
$container.removeClass(activeContainer);

$this.addClass(activeHand);

if ($this.index() === 0) {
$container.addClass(activeContainer);
}
});

$('.to-map').on('click', 'a', function (e) {
e.preventDefault();

if ( window.innerWidth < 1280 && window.innerWidth > 979 ) {
$switcherHand.eq(1).removeClass(activeHand);
$switcherHand.eq(0).addClass(activeHand);

$container.addClass(activeContainer);
}
});

$('.shops-map').on('click', '.more', function (e) {
e.preventDefault();

if ( window.innerWidth < 1280 && window.innerWidth > 979 ) {
$switcherHand.eq(0).removeClass(activeHand);
$switcherHand.eq(1).addClass(activeHand);

$container.removeClass(activeContainer);
}
});

// $('.shops-aside-swiper').swipe({
// 	swipeLeft: function () {
// 		if ( $switcherHand.eq(1).hasClass(activeHand) ) return false;
//
// 		$switcherHand.eq(0).removeClass(activeHand);
// 		$switcherHand.eq(1).addClass(activeHand);
//
// 		$container.removeClass(activeContainer);
// 	},
// 	swipeRight: function () {
// 		if ( $switcherHand.eq(0).hasClass(activeHand) ) return false;
//
// 		$switcherHand.eq(1).removeClass(activeHand);
// 		$switcherHand.eq(0).addClass(activeHand);
//
// 		$container.addClass(activeContainer);
// 	}
// });

}
}
/*toggle view shops end*/

/**!
* contacts map
* */
function contactsMap() {
var myMap,
myPlacemark,
mapId = "#contacts-map",
$mapId = $(mapId),
center = [53.9071097, 27.4923474],
baseImageURL = 'img/';

/*initial map*/
if ( $mapId.length ) {
ymaps.ready(init);

function init(){
/*create new map object*/
myMap = new ymaps.Map (mapId.substring(1), {
center: center,
zoom: 11,
controls: ['fullscreenControl']
});

myPlacemark = new ymaps.Placemark(center, {
hintContent: "Республика Беларусь, 220050, г. Минск, ул. Мясникова, д. 40"
}, {
iconLayout: 'default#image',
iconImageHref: baseImageURL + 'depict-map-2x.png',
iconImageSize: [45, 61],
iconImageOffset: [-22, -59]
});

myMap.geoObjects.add(myPlacemark);

/*add zoom control button*/
var zoomControl = new ymaps.control.ZoomControl({
options: {
size: "small",
position: {right: 10, bottom: 35}
}
});
myMap.controls.add(zoomControl);

/*behaviors setting map*/
myMap.behaviors.disable('scrollZoom');
}
}
}
/*contacts map end*/

/**
* image lazy load
* */
function imgLazyLoad() {
var $productsImg = $('.products-list__img');

if ($productsImg.length) {
$productsImg.find('img').unveil();
}
}
/*image lazy load end*/

/**
* filer products
* */
function filtersProducts() {
// external js:
// 1) isotope.pkgd.js (widgets.js)
// 2) imagesLoaded PACKAGED v4.1.1 (widgets.js)
// 3) jQuery Unveil (widgets.js)

var $grid = $('.filter-panel-js');
if (!$grid.length) return;

function getHashFilter() {
// get filter=filterName
var matches = location.hash.match( /filter=([^&]+)/i );
var hashFilter = matches && matches[1];
return hashFilter && decodeURIComponent( hashFilter );
}

// bind filter button click
var $filterButtonGroup = $('.filter-js');
$filterButtonGroup.on( 'click', 'a', function(e) {
e.preventDefault();

var filterAttr = $( this ).attr('data-filter');
// set filter in hash
location.hash = 'filter=' + encodeURIComponent( filterAttr );
});

var isIsotopeInit = false;

function onHashchange() {
var hashFilter = getHashFilter();
if ( !hashFilter && isIsotopeInit ) {
return;
}
isIsotopeInit = true;
// filter isotope
$grid.isotope({
itemSelector: '.filter-item-js',
layoutMode: 'fitRows',
stagger: 10,
percentPosition: true,
transitionDuration: 400,
hiddenStyle: {
opacity: 0,
// transform: 'scale(0.001)'
transform: 'scale(1)'
},
visibleStyle: {
opacity: 1,
transform: 'scale(1)'
},
// use filterFns
filter: hashFilter
});

// set selected class on button
if ( hashFilter ) {
$filterButtonGroup.find('a').removeClass('selected');
$filterButtonGroup.find('[data-filter="' + hashFilter + '"]').addClass('selected');
}
}

// layout Isotope after each image loads
$grid.imagesLoaded().progress( function() {
$grid.isotope('layout');
});

$grid.on( 'arrangeComplete', function() {
$('.main').trigger('changeSize'); // triggered function of change size the container for reinit events load images ( jQuery Unveil (widgets.js))
});

$(window).on( 'hashchange', onHashchange );

// trigger event handler to init Isotope
onHashchange();
}
/*filters products end*/

/**
* sticky layout
* */
function stickyLayout(){
var topValue = $('.header').outerHeight();

/*sidebar sticky*/
var $sidebar = $(".sidebar-holder");
$sidebar.css('position','static');
if ($sidebar.length) {
var resizeTimerMenu;

$(window).on('load resize', function () {
if(window.innerWidth < 980){
// $sidebar.trigger("sticky_kit:detach").attr('style','');
$sidebar.trigger("sticky_kit:detach").css('position','relative');
return;
}

clearTimeout(resizeTimerMenu);
resizeTimerMenu = setTimeout(function () {
$sidebar.stick_in_parent({
parent: '.main'
// offset_top: topValue
});
}, 100);
});
}
}
/*sticky layout end*/

/**!
* footer at bottom
* */
function footerBottom(){
var $footer = $('.footer');
if($footer.length){
var $tplSpacer = $('<div />', {
class: 'spacer'
});

$('.content').after($tplSpacer.clone());
$('.main').after($tplSpacer.clone());

$(window).on('load resizeByWidth', function () {
var footerOuterHeight = $footer.find('.footer-holder').outerHeight();
$footer.css({
// 'margin-top': -footerOuterHeight
});

$('.spacer').css({
'height': footerOuterHeight
});
})
}
}
/*footer at bottom end*/

/**!
* preloader
* */
function preloadPage(){
$('html').addClass('page-loaded');
}
/*preloader end*/

/** ready/load/resize document **/

$(window).load(function () {
preloadPage();
});

$(document).ready(function(){
placeholderInit();
if(DESKTOP){
customSelect($('select.cselect'));
}
printShow();
mainNavigationInit();
headerShow();
slidersInit();
popupInitial();
jsAccordion();
menuAccordionInit();
fileInput();
initMask();
tabSwitcher();
filterJob();
equalHeightInit();
initJsDrops();
compactor();
shopsLocation();
shopsAccordion();
addShadowTape();
toggleViewShops();
contactsMap();
imgLazyLoad();
filtersProducts();
if(DESKTOP){
stickyLayout();
}

footerBottom();
});