var FADEIMAGES_IMAGES, FADEIMAGES_STEP, FADEIMAGES_INTERVAL, FADEIMAGES_SLEEP, FADEIMAGES_BASEDIR, FADEIMAGES_arrLen, FADEIMAGES_currImg,
    FADEIMAGES_imgs, FADEIMAGES_img0, FADEIMAGES_img0Opacity, FADEIMAGES_img1, FADEIMAGES_img1Opacity, FADEIMAGES_fadding;

$(function() {
 var opt = Joomla.getOptions('mod_fadeimages');
 FADEIMAGES_IMAGES = opt['files'];
 FADEIMAGES_STEP = opt['step'];
 FADEIMAGES_INTERVAL = opt['interval'];
 FADEIMAGES_SLEEP = opt['sleep'];
 FADEIMAGES_BASEDIR = opt['inet'];

 FADEIMAGES_img0 = 0;
 FADEIMAGES_img0Opacity = 100;
 FADEIMAGES_img1 = 1;
 FADEIMAGES_img1Opacity = 0;
 FADEIMAGES_fadding = false;

 FADEIMAGES_arrLen = FADEIMAGES_IMAGES.length;
 if ( FADEIMAGES_arrLen < 2) return;

// if ( !document.getElementById || !document.createElement ) return;

 var div = document.getElementById('fadeimages');
 div.appendChild(document.createElement('img'));
 div.appendChild(document.createElement('img'));

 FADEIMAGES_imgs = document.getElementById('fadeimages').getElementsByTagName('img');

// FADEIMAGES_imgs = $("img[name|='fadeimages']").get();
// console.log(FADEIMAGES_imgs);
// return;

 FADEIMAGES_imgs[FADEIMAGES_img0].src = FADEIMAGES_BASEDIR + FADEIMAGES_IMAGES[0];
 FADEIMAGES_imgs[FADEIMAGES_img0].style.opacity = FADEIMAGES_img0Opacity / 100;

 FADEIMAGES_imgs[FADEIMAGES_img1].src = FADEIMAGES_BASEDIR + FADEIMAGES_IMAGES[1];
 FADEIMAGES_imgs[FADEIMAGES_img1].style.opacity = FADEIMAGES_img1Opacity / 100;

 FADEIMAGES_currImg = 1;

//    if (document.all) {
//	FADEIMAGES_imgs[1].style.filter = "alpha(opacity=0)";
//    } else {
//	FADEIMAGES_imgs[1].style.MozOpacity = 0.00;
//    }
//    FADEIMAGES_imgs[1].src = FADEIMAGES_BASEDIR + FADEIMAGES_IMAGES[1];
//    FADEIMAGES_imgs[1].style.display = "block";
//    FADEIMAGES_currImg = 1;

 FADEIMAGES_fadding = true;
 setTimeout("FADEIMAGES_crossFade()", FADEIMAGES_SLEEP);

});

function FADEIMAGES_crossFade()
{
 if ( FADEIMAGES_fadding )
 {
  FADEIMAGES_img0Opacity -= FADEIMAGES_STEP;
  FADEIMAGES_img1Opacity += FADEIMAGES_STEP;

//	if(document.all) {
//	    FADEIMAGES_imgs[FADEIMAGES_img0].style.filter = "alpha(opacity=" + FADEIMAGES_img0Opacity + ")";
  FADEIMAGES_imgs[FADEIMAGES_img0].style.opacity = FADEIMAGES_img0Opacity / 100;
//	    FADEIMAGES_imgs[FADEIMAGES_img1].style.filter = "alpha(opacity=" + FADEIMAGES_img1Opacity + ")";
  FADEIMAGES_imgs[FADEIMAGES_img1].style.opacity = FADEIMAGES_img1Opacity / 100;
//	} else {
//	    FADEIMAGES_imgs[FADEIMAGES_img0].style.MozOpacity = FADEIMAGES_img0Opacity/100.0;
//	    FADEIMAGES_imgs[FADEIMAGES_img1].style.MozOpacity = FADEIMAGES_img1Opacity/100.0;
//	}
	
  if ( FADEIMAGES_img0Opacity <= 0) FADEIMAGES_fadding = false;
  setTimeout("FADEIMAGES_crossFade()", FADEIMAGES_INTERVAL);
 } else {
  FADEIMAGES_img0Opacity = 100;
  FADEIMAGES_img1Opacity = 0;

  t = FADEIMAGES_img0;
  FADEIMAGES_img0 = FADEIMAGES_img1;
  FADEIMAGES_img1 = t;

  if ( ++FADEIMAGES_currImg >=FADEIMAGES_arrLen ) FADEIMAGES_currImg = 0;

  FADEIMAGES_imgs[FADEIMAGES_img1].src = FADEIMAGES_BASEDIR + FADEIMAGES_IMAGES[ FADEIMAGES_currImg ];

  FADEIMAGES_fadding = true;
  setTimeout("FADEIMAGES_crossFade()", FADEIMAGES_SLEEP);
 }
}
