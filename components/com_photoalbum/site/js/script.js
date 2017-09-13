var AUDIO_SRC, AUDIO_CURRENT, AUDIO_LENGTH;

$(function() {
 AUDIO_SRC = Joomla.getOptions('com_photoalbum');
 AUDIO_CURRENT = 0;
 AUDIO_LENGTH = AUDIO_SRC.length;

 $("audio#photoalbom").attr("src", AUDIO_SRC[0]);
});

function audio_end(obj) {
 if (++AUDIO_CURRENT >= AUDIO_LENGTH) AUDIO_CURRENT = 0;
 obj.src = AUDIO_SRC[AUDIO_CURRENT];
};
