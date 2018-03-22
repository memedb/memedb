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

  $("#imp-bg-fade").click(function() {
    $(".l-sett-opt").css({
      opacity: "0",
      right: "120px"
    });
    $("#imp-message, #imp-bg-fade").css("opacity", "0");
    setTimeout(function() {
      $("#imp-message, #imp-bg-fade, .l-sett-opt").css("display", "none");
    }, 100);
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
