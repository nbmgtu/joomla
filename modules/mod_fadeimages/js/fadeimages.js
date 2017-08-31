window.addEventListener ? window.addEventListener('load', FADEIMAGES_init, false) : window.attachEvent('onload', FADEIMAGES_init);

var FADEIMAGES_IMAGES = new Array();
var FADEIMAGES_arrLen;
var FADEIMAGES_currImg;
var FADEIMAGES_imgs;
var FADEIMAGES_img0 = 0;
var FADEIMAGES_img0Opacity = 100;
var FADEIMAGES_img1 = 1;
var FADEIMAGES_img1Opacity = 0;
var FADEIMAGES_STEP = 2;
var FADEIMAGES_INTERVAL = 35;
var FADEIMAGES_SLEEP = 3000;
var FADEIMAGES_BASEDIR;
var FADEIMAGES_fadding = false;

function FADEIMAGES_init()
{
    FADEIMAGES_arrLen = FADEIMAGES_IMAGES.length;
    if ( !document.getElementById || !document.createElement ) return;
    if ( FADEIMAGES_arrLen < 2) return;

    FADEIMAGES_imgs = document.getElementById('fadeimages').getElementsByTagName('img');

    if (document.all) {
	FADEIMAGES_imgs[1].style.filter = "alpha(opacity=0)";
    } else {
	FADEIMAGES_imgs[1].style.MozOpacity = 0.00;
    }
    FADEIMAGES_imgs[1].src = FADEIMAGES_BASEDIR + FADEIMAGES_IMAGES[1];
    FADEIMAGES_imgs[1].style.display = "block";
    FADEIMAGES_currImg = 1;

    FADEIMAGES_fadding = true;
    setTimeout("FADEIMAGES_crossFade()", FADEIMAGES_SLEEP);
}

function FADEIMAGES_crossFade() {
    if ( FADEIMAGES_fadding ) {
	FADEIMAGES_img0Opacity -= FADEIMAGES_STEP;
	FADEIMAGES_img1Opacity += FADEIMAGES_STEP;

//	if(document.all) {
	    FADEIMAGES_imgs[FADEIMAGES_img0].style.filter = "alpha(opacity=" + FADEIMAGES_img0Opacity + ")";
	    FADEIMAGES_imgs[FADEIMAGES_img0].style.opacity = FADEIMAGES_img0Opacity / 100;
	    FADEIMAGES_imgs[FADEIMAGES_img1].style.filter = "alpha(opacity=" + FADEIMAGES_img1Opacity + ")";
	    FADEIMAGES_imgs[FADEIMAGES_img1].style.opacity = FADEIMAGES_img1Opacity / 100;
//	} else {
//	    FADEIMAGES_imgs[FADEIMAGES_img0].style.MozOpacity = FADEIMAGES_img0Opacity/100.0;
//	    FADEIMAGES_imgs[FADEIMAGES_img1].style.MozOpacity = FADEIMAGES_img1Opacity/100.0;
//	}
	
	if (FADEIMAGES_img0Opacity <= 0) {
	    FADEIMAGES_fadding = false;
	    FADEIMAGES_img0Opacity = 100;
	    FADEIMAGES_img1Opacity = 0;
	}
	setTimeout("FADEIMAGES_crossFade()", FADEIMAGES_INTERVAL);
    } else {
	FADEIMAGES_imgs[FADEIMAGES_img0].src = FADEIMAGES_BASEDIR + FADEIMAGES_IMAGES[ (FADEIMAGES_currImg+1 < FADEIMAGES_arrLen) ? FADEIMAGES_currImg+1 : 0 ];
	FADEIMAGES_currImg = (FADEIMAGES_currImg+1 == FADEIMAGES_arrLen) ? 0 : FADEIMAGES_currImg+1;
	
	t = FADEIMAGES_img0;
	FADEIMAGES_img0 = FADEIMAGES_img1;
	FADEIMAGES_img1 = t;

	FADEIMAGES_fadding = true;
	setTimeout("FADEIMAGES_crossFade()", FADEIMAGES_SLEEP);
    }
}
