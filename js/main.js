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

  $(".h-more").click(function(event) {
    openOptions(this.parentElement.id);
    event.stopPropagation();
  });

  $("#imp-bg-fade").click(function() {
    $(".l-sett-opt").css({
      opacity: "0",
      right: "50px"
    });
    $("#imp-message, #imp-bg-fade").css("opacity", "0");
    setTimeout(function() {
      $("#imp-message, #imp-bg-fade, .l-sett-opt").css("display", "none");
    }, 100);
    closeSettings();
    closeTagSearch();
    closeStats();
    closeAddLib();
    closeAccount();
    closePost();
  });

  $(".openSettings").click(function() {
    openSettings();
    $("#imp-bg-fade").css("opacity", "");
  });

  $(".closeSettings").click(function() {
    closeSettings();
    $("#imp-message, #imp-bg-fade").css("opacity", "0");
  });

  $(".openTagSearch").click(function() {
    openTagSearch();
    $("#imp-bg-fade").css("opacity", "");
  });

  $(".closeTagSearch").click(function() {
    closeTagSearch();
    $("#imp-message, #imp-bg-fade").css("opacity", "0");
  });

  $(".openStats").click(function() {
    openStats();
    $("#imp-bg-fade").css("opacity", "");
  });

  $(".closeStats").click(function() {
    closeStats();
    $("#imp-message, #imp-bg-fade").css("opacity", "0");
  });

  $(".openAddLib").click(function() {
    openAddLib();
    $("#imp-bg-fade").css("opacity", "");
  });

  $(".closeAddLib").click(function() {
    closeAddLib();
    $("#imp-message, #imp-bg-fade").css("opacity", "0");
  });

  $(".openAccount").click(function() {
    openAccount();
    $("#imp-bg-fade").css("opacity", "");
  });

  $(".closeAccount").click(function() {
    closeAccount();
    $("#imp-message, #imp-bg-fade").css("opacity", "0");
  });

  $(".openPost").click(function() {
    openPost();
    $("#imp-bg-fade").css("opacity", "");
  });

  $(".closePost").click(function() {
    closePost();
    $("#imp-message, #imp-bg-fade").css("opacity", "0");
  });

  $(".s-tab").click(function() {
    if(!(this.classList.contains("s-selected"))){
      $(".s-tab").toggleClass("s-selected");
      $(".s-c-wrapper").toggleClass("s-slide")

    }
  });

  $(".t-cross").click(function() {

  });
});

function sendCommand(name, session, data, callback) {
  var dataString = "";
  for (var key in data) {
    if (data.hasOwnProperty(key)) {
      dataString += key + "=" + data[key] + "&";
    }
  }
  dataString += "session=" + session;

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status ==  200) {
      callback(JSON.parse(this.responseText));
    }
  }
  xhttp.open("POST", "/api/" + name, true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(dataString);
}

function followAction() {
  var cookies = document.cookie.split("; ");
  var session_id = null;
  for (i = 0; i < cookies.length; i++) {
    var cookie = cookies[i];
    if (cookie.startsWith("PHPSESSID")) {
      session_id = cookie.split("=")[1];
      break;
    }
  }

  var elmt = document.getElementById("follow-btn");

  if (elmt.className == "follow" || elmt.className == "unfollow") {
    sendCommand(elmt.className, session_id, {handle: elmt.dataset.handle}, function(response) {
      if (response.following) {
        elmt.className = "unfollow";
      } else {
        elmt.className = "follow";
      }
      elmt.innerHTML = "<span>" + response.followers + "</span>";
    });
  }
}

function openOptions(id) {
  console.log(id);
  var offset = $("#" + id).offset();
  $(".l-sett-opt").css({
    top: (offset.top + 15) + "px",
    opacity: "0",
    right: "50px",
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
    $("#imp-bg-fade").css("display", "");
    setTimeout(function() {
      $(".l-sett-opt").css({
        opacity: "",
        right: ""
      });
      $("#imp-bg-fade").css("opacity", "");
    }, 10);
}

function closeSettings(){
    $(".s-settings").css({
      display: "none"
    });
    $("#imp-bg-fade").css("display", "none");
}

function openTagSearch(){
    $(".tagFinder").css({
      display: "block"
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

function closeTagSearch(){
    $(".tagFinder").css({
      display: "none"
    });
    $("#imp-bg-fade").css("display", "none");
}

function openStats(){
    $(".stats").css({
      display: "block"
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

function closeStats(){
    $(".stats").css({
      display: "none"
    });
    $("#imp-bg-fade").css("display", "none");
}

function openAddLib(){
    $(".addLib").css({
      display: "block"
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

function closeAddLib(){
    $(".addLib").css({
      display: "none"
    });
    $("#imp-bg-fade").css("display", "none");
}

function openAccount(){
    $(".s-dropdown").css({
      display: "block"
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

function closeAccount(){
    $(".s-dropdown").css({
      display: "none"
    });
    $("#imp-bg-fade").css("display", "none");
}

function openPost(){
    window.scrollTo(0, 0);
    $(".m-post").css({
      display: "block"
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

function closePost(){
    $(".m-post").css({
      display: "none"
    });
    $("#imp-bg-fade").css("display", "none");
}
