  function blinkerConstruct () {
    var node = document.createElement("DIV");
	node.id="_blink_blink_";
	node.style.border="1px solid #00ff00";
	node.style.position="fixed";
	node.style.top="12px";
	node.style.right="4px";
	node.style.width="10px";
	node.style.height="10px";
	node.style.backgroundColor="blue";
  	document.body.appendChild(node);
  }
  
  function blinkerRed() {
  document.getElementById("_blink_blink_").style.backgroundColor="red";
  }
  function blinkerGreen() {
  document.getElementById("_blink_blink_").style.backgroundColor="green";
  }
  
  function blinkerToggle() {
  var d = document.getElementById("_blink_blink_");
  if (d.style.backgroundColor=="green") {d.style.backgroundColor="orange";} else {d.style.backgroundColor="green";};
  }
  
  function blink() {
    setInterval(blinkerToggle,1000);
  }
  
function blinkblink() {  // do it all!
   blinkerConstruct();
   blink();
}