$( function() {
 $( "#learnmkgtu" ).tooltip({
  tooltipClass: "learnmkgtu",
  content: function() {
   var element = $( this );
   if ( element.is( "[tooltip]" ) ) {
    return element.attr( "tooltip" );
   }
  },
 });
});
