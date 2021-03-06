<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>AHS LEARNING - DIV SHIFT DEMO</title>
	<style type="text/css" media="screen">
		
		#slideout {
			position: fixed;
			top: 650px;
			left: 0;
			width: 35px;
			padding: 12px 0;
			text-align: center;
			background: #6DAD53;
			-webkit-transition-duration: 0.3s;
			-moz-transition-duration: 0.3s;
			-o-transition-duration: 0.3s;
			transition-duration: 0.3s;
			-webkit-border-radius: 0 5px 5px 0;
			-moz-border-radius: 0 5px 5px 0;
			border-radius: 0 5px 5px 0;
		}
		#slideout_inner {
			position: fixed;
			top: 650px;
			left: -250px;
			background: #6DAD53;
			width: 200px;
			padding: 25px;
			height: 130px;
			-webkit-transition-duration: 0.3s;
			-moz-transition-duration: 0.3s;
			-o-transition-duration: 0.3s;
			transition-duration: 0.3s;
			text-align: left;
			-webkit-border-radius: 0 0 5px 0;
			-moz-border-radius: 0 0 5px 0;
			border-radius: 0 0 5px 0;
		}
		#slideout_inner textarea {
			width: 190px;
			height: 100px;
			margin-bottom: 6px;
		}
		#slideout:hover {
			left: 250px;
		}
		#slideout:hover #slideout_inner {
			left: 0;
		}
		
		#left {
		  float:left;
		  height:85%; 
		  width:500px;
		  border:1px solid black;
			-webkit-transition-duration: 1.5s;
			-moz-transition-duration: 1.5s;
			-o-transition-duration: 1.5s;
			transition-duration: 1.5s;
		}
		#right {
		  float:left;
		  height:85%; 
		  width:500px;
		  margin-left:8px;
		  border:1px solid black;
			-webkit-transition-duration: 1.5s;
			-moz-transition-duration: 1.5s;
			-o-transition-duration: 1.5s;
			transition-duration: 1.5s;
		}
		
	</style>
	
	<script>

	function leftExpand() {
	   var w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	   var l=document.getElementById("left");
	   var r=document.getElementById("right");
//	   l.style.marginLeft="0px";
       if (w<1281) {
	   l.style.width="80%";
	   r.style.width="15%";
	   }
	 }

	 function rightExpand() {
	   var w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	   var l=document.getElementById("left");
	   var r=document.getElementById("right");
//	   l.style.marginLeft="-450px";
       if (w<1281) {
	   l.style.width="15%";
	   r.style.width="80%";
	   }
	 }

	 function init() {
	   var w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	   var h = window.innerHeight|| document.documentElement.clientHeight|| document.body.clientHeight;
	   var l=document.getElementById("left");
	   var r=document.getElementById("right");
	   l.style.width=(w*0.35)+"px";
	   r.style.width=(w*0.63)+"px";
	   
	 }
	 
	 </script>
</head>
<body onload="init();">
 
	<div id="slideout">
		<img src="feedback.png" alt="Feedback" />
		<div id="slideout_inner">
			<form>
				<textarea></textarea>
				<input type="submit" value="Post feedback"></input>
			</form>
		</div>
	</div>
	
	<div id="left" onmouseenter="leftExpand()"> LEFT SIDE CONTENT 
        <img src="img1.jpg" style="width:100%" />
        <img src="img1.jpg" style="max-width:30%; min-width:200px" />
        <img src="img1.jpg" style="max-width:30%; min-width:200px" />
        <img src="img1.jpg" style="max-width:30%; min-width:200px" />
        </div>
	<div id="right" onmouseenter="rightExpand()"> RIGHT SIDE CONTENT 
        <img src="img2.jpg" style="width:100%" />
        </div>

</body>
</html>