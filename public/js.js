var ikon = document.getElementById("ikon");
    ikon.onclick = function(){
        document.body.classList.toggle("light-theme");
            if (document.body.classList.contains("light-theme")){
                document.getElementById("gambar").style.backgroundImage="url(backlight.jpg)";
                ikon.src = "images/moon.png";
                console.log('Jadi terang')
            }else{
                document.getElementById("gambar").style.backgroundImage="url(background.jpg)";
                ikon.src = "images/sun.png";
                console.log('Jadi gelap')
            }
    }
	
	
	

// Click on a close button to hide the current list item
var close = document.getElementsByClassName("close");
var i;
for (i = 0; i < close.length; i++) {
  close[i].onclick = function() {
    var div = this.parentElement;
    div.style.display = "none";
  }
}
// Create a new list item when clicking on the "Add" button
function newElement() {
  var li = document.createElement("li");
  var inputValue = document.getElementById("myInput").value;
  var t = document.createTextNode(inputValue);
  li.appendChild(t);
  if (inputValue === '') {
    alert("You must write something!");
  } else {
    document.getElementById("myUL").appendChild(li);
  }
  document.getElementById("myInput").value = "";

  var span = document.createElement("SPAN");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  li.appendChild(span);

  for (i = 0; i < close.length; i++) {
    close[i].onclick = function() {
      var div = this.parentElement;
      div.style.display = "none";
    }
  }
}