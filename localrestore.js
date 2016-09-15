  function restoreConstruct () {
    var node = document.createElement("DIV");
	node.id="_restore_restore_";
	node.style.border="1px solid #00ff00";
	node.style.position="fixed";
	node.style.top="12px";
	node.style.right="64px";
	node.style.width="10px";
	node.style.height="10px";
	node.style.backgroundColor="blue";
  	document.body.appendChild(node);
  }
  
  function restoreRed() {
  document.getElementById("_blink_blink_").style.backgroundColor="lightblue";
  }
  function restoreGreen() {
  document.getElementById("_blink_blink_").style.backgroundColor="green";
  }
  
  function restoreToggle() {
  var d = document.getElementById("_restore_restore_");
  if (d.style.backgroundColor=="green") {d.style.backgroundColor="lightblue";} else {d.style.backgroundColor="green";};
  }
  
  function rblink() {
    setInterval(restoreToggle,1000);
  }
  
function restoreblink() {  // do it all!
   restoreConstruct();
   rblink();
}