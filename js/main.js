toggled = new Array();

$(document).ready(function() {
  libs = $(".library");
  for (i = 0; i < libs.length; i++) libs[i].id = i.toString();
  libs.click(function(event) {
    if(toggled[this.id]) {
			this.querySelector(".l-settings").style.transform = "";
			this.nextElementSibling.style.height = "0px";
		} else {
			this.querySelector(".l-settings").style.transform = "rotate(180deg)";
			content = this.nextElementSibling;
			content.style.height = "";
			height = content.clientHeight;
			content.style.height = "0px";
			setTimeout(function() {
				content.style.height = height.toString() + "px";
			}, 10);
		}
		toggled[this.id] = !toggled[this.id];
  });

  $(".l-drop").click(function(event) {
    openOptions(this.parentElement.id);
    event.stopPropagation();
  });

  $(".e-settings").click(function() {
    openSettings();
  });

  $(".material-icons.black.s-delete").click(function() {
    closeSettings();
  });
});

function openOptions(id) {
  console.log(id);
  var offset = $("#" + id).offset();
  $(".l-sett-opt").css({
    top: (offset.top + 15) + "px",
    opacity: "0",
    right: "120px",
    display: ""
  });
  $("#imp-bg-fade").css("display", "");
  setTimeout(function() {
    $(".l-sett-opt").css({
      opacity: "",
      right: ""
    });
    $("#imp-bg-fade").css("opacity", "");
  }, 10);
}

function showError(message) {
  elmt = $("#imp-bg-fade, #imp-message");
  elmt.css("display","");
  setTimeout(function() {elmt.css("opacity", "")}, 10);
  $("#imp-message .imp-p").text(message);
}

function openSettings(){
    $(".s-settings").css({
      display: "table"
    });
}

function closeSettings(){
    $(".s-settings").css({
      display: "none"
    });
}

function settingsGeneral(){
    //Make border bottom blue

    //Make blue border from other section

    //Hide Other Section

    //Show this one
}

function settingsAccount(){
  //Make border bottom blue

  //Make blue border from other section

  //Hide Other Section

  //Show this one
}
