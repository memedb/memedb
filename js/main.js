toggled = new Array();

searchCode = "";

var editLib = false;

var SID = null;

var openPost = "";

var parent = null;

$(document).ready(function() {
  var isSidenavOpen = false;
  var recHeight = 420;
  var isSidenavShown = false;
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
        content.style.margin = "0px";
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
    $("#imp-message, #imp-bg-fade").css("opacity", "0");
    setTimeout(function() {
      $("#imp-message, #imp-bg-fade").css("display", "none");
    }, 100);
    closeSettings();
    closeTagSearch();
    closeStats();
    closeAddLib();
    closeAccount();
    closePost();
    closeBalance();
    closeOptions();
    hideSidenav();
    hideImagePreview();
  });

  $(".openSidenav").click(function() {

    if(!isSidenavOpen){
      showSidenav();
    } else {
      hideSidenav();
    }

    isSidenavShown = !isSidenavShown;
  });

  $(".expand-sidenav").click(function() {

    if(!isSidenavOpen){
      expandSidenav();
    } else {
      compactSidenav();
    }

    isSidenavOpen = !isSidenavOpen;
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
    tagSearch("");
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

  $(".openBalance").click(function() {
    openBalance();
    $("#imp-bg-fade").css("opacity", "");
  });

  $(".closeBalance").click(function() {
    closeBalance();
    $("#imp-message, #imp-bg-fade").css("opacity", "0");
  });

  $(".openEcSearch").click(function() {
    openBalance();
    $("#imp-bg-fade").css("opacity", "");
  });

  $(".closeEcSearch").click(function() {
    closeBalance();
    $("#imp-message, #imp-bg-fade").css("opacity", "0");
  });

  $(".expand-rec-section").click(function() {
    expandRec();
  });

  $(".s-tab").click(function() {
    if(!(this.classList.contains("s-selected"))){
      $(".s-tab").toggleClass("s-selected");
      $(".s-c-wrapper").toggleClass("s-slide")
    }
  });

  $(".t-cross").click(function() {
    var elmt = this.parentElement;
    sendCommand("delete_favorite", null, {type: this.dataset.type}, function(response) {
      elmt.parentNode.removeChild(elmt);
    });
  });

  $(".c-title-holder .searchbar input").keyup(function() {
    tagSearch(this.value);
  });

  $(".sendAddLib").click(function() {
    var data = $("#libForm").serializeArray();
    console.log(data);
    var temp = new Array();
    for (var i = 0; i < data.length; i++) {
      dataP = data[i];
      temp[dataP['name']] = dataP['value'];
    }
    data = temp;
    if (editLib) {
      var id = document.getElementsByClassName("l-sett-opt")[0].dataset.id;
      data['id'] = id;
    }
    sendCommand(editLib ? "edit_library" : "create_library", null, data, function(response) {
      console.log(response);
      location.reload();
    });
  });

  $("#libForm").submit(function(event) {
    event.preventDefault();
    $(".sendAddLib").click();
  });
});

function tagSearch(value) {
  searchCode = uuid();
  sendCommand("search_tag", null, {code: searchCode, q: value}, function(response) {
    console.log(response);
    if (searchCode == response.code) {
      $(".c-b-wrapper").text("");
      for (var i = 0; i < response.results; i++) {
        var tag = response.tags[i];
        $(".c-b-wrapper").append("<div class=\"c-result\" onclick=\"addTag('" + tag + "')\"><h1 class=\"c-r-title\">" + tag + "</h1><div class=\"type c\">+</div></div>");
      }
    }
  });
}

function addTag(tag) {
  sendCommand("add_favorite", null, {type: tag}, function(response) {
    console.log(response.favorites);
  });
}

function uuid() {
  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
    return v.toString(16);
  });
}

function sendCommand(name, session, data, callback) {
  if (session == null) {
    var cookies = document.cookie.split("; ");
    for (i = 0; i < cookies.length; i++) {
      var cookie = cookies[i];
      if (cookie.startsWith("PHPSESSID")) {
        session = cookie.split("=")[1];
        SID = session;
        break;
      }
    }
  }

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
      //console.log("raw: " + this.responseText);
      response = JSON.parse(this.responseText);
      if (response.status == "success")
        callback(response);
    }
  }
  xhttp.open("POST", "/api/" + name, true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(dataString);
}

function getImageHtml(id, className, type, width, height, elmtWidth) {
  height = (height/width) * elmtWidth;
  return "<img class=" + className + " src=\"/images/" + id + "." + type + " style=\"height:" + height + "px;\">"
}

function updateImagePreview() {
  sendCommand("get_post", null, {id: openPost}, function(response) {
    $.ajax({
      type: 'GET',
      url: '/meme_preview.php?id=' + openPost + '&SID=' + SID,
      success: function(response) {
        $(".meme-preview-box-hover").remove();
        $("body").append(response);
        $("#imp-bg-fade").css("display", "");
      }
    });
  });
}

function showImagePreview(event) {
  var id = event.target.dataset.id;
  sendCommand("get_post", null, {id: id}, function(response) {
    $.ajax({
      type: 'GET',
      url: '/meme_preview.php?id=' + id + '&SID=' + SID,
      success: function(response) {
        openPost = id;
        $("body").append(response);
        $("#imp-bg-fade").css("display", "");
      }
    });
  });
}

function hideImagePreview() {
  $(".meme-preview-box-hover").remove();
}

function updateVotes(id, votes, vote) {
  console.log(vote);
  var elmt = document.getElementById("votes_" + id);
  elmt.innerHTML = votes;
  if (vote == -1) {
    elmt.previousElementSibling.classList.remove("vote-selected");
    elmt.nextElementSibling.classList.add("vote-selected");
  } else if (vote == 1) {
    elmt.previousElementSibling.classList.add("vote-selected");
    elmt.nextElementSibling.classList.remove("vote-selected");
  } else {
    elmt.previousElementSibling.classList.remove("vote-selected");
    elmt.nextElementSibling.classList.remove("vote-selected");
  }
}

function upvotePost(id) {
  sendCommand("upvote_post", null, {id: id}, function(response) {
    updateVotes(id, response.votes, response.vote);
  });
}

function downvotePost(id) {
  sendCommand("downvote_post", null, {id: id}, function(response) {
    updateVotes(id, response.votes, response.vote);
  });
}

function upvoteComment(id) {
  sendCommand("upvote_comment", null, {id: id}, function(response) {
    updateVotes(id, response.votes, response.vote);
  });
}

function downvoteComment(id) {
  sendCommand("downvote_comment", null, {id: id}, function(response) {
    updateVotes(id, response.votes, response.vote);
  });
}

function repost(id, elmt) {
  sendCommand("repost", null, {id: id}, function(response) {
    elmt.children[elmt.childElementCount-1].innerHTML = response.reposts;
    if (response.reposted == 0)
      elmt.children[0].classList.remove("vote-selected");
    else
      elmt.children[0].classList.add("vote-selected");
  });
}

function postComment() {
  var text = document.getElementById("comment_text").value;
  if (text.length > 0) {
    sendCommand("post_comment", null, {text: text, post: openPost, parent: parent}, function(response) {
      updateImagePreview();
    });
  }
}

function setParent(id) {
  parent = id;
}

function showMore(id, elmt) {
  document.getElementById("hidden_" + id).style.display = null;
  elmt.style.display = "none";
  elmt.nextElementSibling.style.display = null;
}

function showLess(id, elmt) {
  document.getElementById("hidden_" + id).style.display = "none";
  elmt.style.display = "none";
  elmt.previousElementSibling.style.display = null;
}

function focusComment() {
  document.getElementById("comment_text").focus();
}

function reply(id, handle) {
  parent = id;
  var elmt = document.getElementById("reply_to");
  elmt.innerHTML = "In reply to <b>@" + handle + "</b>";
  elmt.style.display = null;
  document.getElementById("comment_text").style.marginTop = "22px";
}

function uploadFile(file, session, type, parent, library) {
  if (session == null) {
    var cookies = document.cookie.split("; ");
    for (i = 0; i < cookies.length; i++) {
      var cookie = cookies[i];
      if (cookie.startsWith("PHPSESSID")) {
        session = cookie.split("=")[1];
        SID = session;
        break;
      }
    }
  }

  var formData = new FormData();
  formData.append('file', file);
  formData.append('type', type);
  formData.append('parent', parent);
  formData.append('library', library);
  formData.append('session', session);

  var postsCont = null;
  var libCont = null;

  var elmts = document.getElementsByClassName("l-content");
  for (var i = 0; i < elmts.length; i++) {
    if (elmts[i].dataset.id == library) {
      libCont = elmts[i];
    }
    if (elmts[i].dataset.id == "POSTS" && library != "POSTS") {
      postsCont = elmts[i];
    }
  }

  var id = (Math.random() + 1).toString(36).substring(7);

  $(".upload-popup-hover").css("display", "");
  $("#uploads").append(""
  + "<div class=\"upload-popup-item\">"
  + "<i class=\"material-icons l-icon upload\">image</i>"
  + "<h1 class=\"upload-title\">" + (file.name.length > 15 ? file.name.substring(0, 15) + "..." : file.name) + "</h1>"
  + "<div id=\"progress-" + id + "\" class=\"progress-circle p0\">"
  + "<div class=\"left-half-clipper\">"
  + "<div class=\"first50-bar\"></div>"
  + "<div class=\"value-bar\"></div>"
  + "</div>"
  + "</div>"
  + "</div>");

  $.ajax({
    type: 'POST',
    url: '/api/create_post',
    contentType: false,
    cache: false,
    processData: false,
    data: formData,
    xhr: function() {
      var XHR = null;
      if ( window.ActiveXObject ) {
        XHR = new window.ActiveXObject( "Microsoft.XMLHTTP" );
      } else {
        XHR = new window.XMLHttpRequest();
      }

      XHR.upload.addEventListener("progress", function (event) {
        if(event.lengthComputable) {
          var percentage = Math.round((event.loaded / event.total) * 100);
          console.log(percentage);
          document.getElementById("progress-" + id).className = "progress-circle p" + percentage + (percentage > 50 ? " over50" : "");
        }
      });

      return XHR;
    },
    success: function(response) {
      document.cookie = "PHPSESSID="+SID+"; path=/";
      response = JSON.parse(response);
      console.log(response);
      $(libCont).find(".empty-library-content").remove();
      libCont.innerHTML += getImageHtml(response.id, "l-img", type);
      if (postsCont != null) {
        $(postsCont).find(".empty-library-content").remove();
        postsCont.innerHTML += getImageHtml(response.id, "l-img", type);
      }
    }
  });
  // setInterval(function() {
  //   getFileProgress(key);
  // }, 1000);
}

function loadPage(url, callback) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status ==  200) {
      callback(this.responseText);
    }
  }
  xhttp.open("GET", url, true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send();
}

function followAction(elmt) {
  if (elmt.classList.contains("follow") || elmt.classList.contains("unfollow")) {
    sendCommand((elmt.classList.contains("follow") ? "follow" : "unfollow"), null, {handle: elmt.dataset.handle}, function(response) {
      if (response.following) {
        elmt.classList.remove("follow");
        elmt.classList.add("unfollow");
      } else {
        elmt.classList.remove("unfollow");
        elmt.classList.add("follow");
      }
      elmt.innerHTML = "<span>" + response.followers + "</span>";
    });
  }
}

function openOptions(id) {
  var offset = $("#" + id).offset();
  $(".l-sett-opt").css({
    top: (offset.top + 15) + "px",
    opacity: "0",
    right: "50px",
    display: ""
  });
  $("#imp-bg-fade").css("display", "");
  setTimeout(function() {
    var dataId = document.getElementById(id).dataset.id;
    document.getElementsByClassName("l-sett-opt")[0].dataset.id = dataId;
    var ids = ["POSTS", "REPOSTS", "FAVORITES"];
    if (ids.includes(dataId)) {
      $(".editable_lib").css({
        display: "none"
      });
    } else {
      $(".editable_lib").css({
        display: ""
      });
    }
    $(".l-sett-opt").css({
      opacity: "",
      right: ""
    });
    $("#imp-bg-fade").css("opacity", "");
  }, 10);
}

function closeOptions() {
  $(".l-sett-opt").css({
    opacity: "0",
    right: "50px"
  });
  $("#imp-bg-fade").css("display", "");
  setTimeout(function() {
    $(".l-sett-opt").css("display", "none");
  }, 100);
}

function deleteLib() {
  var id = document.getElementsByClassName("l-sett-opt")[0].dataset.id;
  sendCommand("delete_library", null, {"id": id}, function(response){
    if (response.status == "success") {
      location.reload();
    }
  });
}

function confirmDeleteLib() {
  elmt = $("#imp-bg-fade, #imp-message");
  elmt.css("display","");
  $(".l-sett-opt").css({
    opacity: "0",
    right: "50px"
  });
  setTimeout(function() {elmt.css("opacity", "")}, 10);
}

function openLibSettings() {
  document.getElementById("libForm").reset();
  var id = document.getElementsByClassName("l-sett-opt")[0].dataset.id;
  sendCommand("get_library", null, {"id": id}, function(response) {
    var lib = response;
    var vis = lib.visibility;
    var name = lib.name;
    var priv = lib.private;
    closeOptions();
    openAddLib();
    $("#lib_visibility_" + vis).prop("checked", true);
    $("#lib_name").val(name);
    $("#lib_private").prop("checked", priv == 1);
    $("#lib_edit_title").html("EDIT LIBRARY");
    $(".sendAddLib").html("Save");
    editLib = true;
  });
}

function openSettings(){
  closeAccount();
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

function fadeToDark(){
  $("#imp-bg-fade").css("display", "");
  setTimeout(function() {
    $(".l-sett-opt").css({
      opacity: "",
      right: ""
    });
    $("#imp-bg-fade").css("opacity", "");
  }, 10);
}

function unfade(){
  $("#imp-bg-fade").css({
    'opacity' : '0'
  });
  setTimeout(function() {
    $(".l-sett-opt").css({
      'display' : 'none'
    });
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
  editLib = false;
  document.getElementById("libForm").reset();
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
  $("#lib_edit_title").html("ADD LIBRARY");
  $(".sendAddLib").html("Add");
}

function openEditLib() {
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
    $(".peep").children().css('filter', 'blur(5px)');
    $(".s-dropdown").css('filter', 'blur(0px)');
    $(".peep").css('background','#222');
}

function closeAccount(){
    $(".s-dropdown").css({
      display: "none"
    });
    $("#imp-bg-fade").css("display", "none");
    $(".peep").children().css('filter', 'blur(0px)');
    $(".peep").css('background','#fff');
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

function openBalance(){
    $(".balance-message").css({
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
    $(".peep").children().css('filter', 'blur(5px)');
    $(".balance-message").css('filter', 'blur(0px)');
    $(".peep").css('background','#222');
}

function closeBalance(){
    $(".balance-message").css({
      display: "none"
    });
    $("#imp-bg-fade").css("display", "none");
    $(".peep").children().css('filter', 'blur(0px)');
    $(".peep").css('background','#fff');
}

function expandSidenav(){
  $(".sidenav-home").css({
    'width' : "950px"
  });
  $(".home-content").css({
    'width' : 'auto',
    'margin-left' : '950px'
  });
  $(".searchbar").css({
    'display' : 'none',
    'opacity' : '0'
  });
  $(".expand-sidenav").css({
    'transform' : 'rotate(-30deg)'
  });
  $(".exp-post-corridor").css({
    'display' : 'inline-block'
  });
  $(".tl-post-title").css({
    'display' : 'inline-block'
  });
  setTimeout(function() {
    $(".exp-post-corridor").css({
      'display' : 'inline-block'
    });
    setTimeout(function() {
      $(".exp-post-corridor").css({
        'opacity' : '1'
      });
    }, 10);
  }, 100);
  setTimeout(function() {
    $(".tl-post-title").css({
      'display' : 'inline-block'
    });
    setTimeout(function() {
      $(".tl-post-title").css({
        'opacity' : '1'
      });
    }, 10);
  }, 100);

}

function compactSidenav(){
  $(".sidenav-home").css({
    width: "300px"
  });
  $(".home-content").css({
    'width' : 'auto',
    'margin-left' : '300px'
  });
  $(".searchbar").css({
    'display' : 'block'
  });
  $(".expand-sidenav").css({
    'transform' : 'rotate(30deg)'
  });
  $(".exp-post-corridor").css({
    'display' : 'none'
  });
  setTimeout(function() {
    $(".exp-post-corridor").css({
      'display' : 'none',
      'opacity' : '0'
    });
    $(".tl-post-title").css({
      'display' : 'none'
    });
  }, 10);
  $(".tl-post-title").css({
    'opacity' : '0'
  });
  setTimeout(function() {
    $(".searchbar").css({
      'display' : 'block',
      'opacity' : '1'
    });
  }, 100);
}

function showSidenav(){
  $(".sidenav-home").css({
    'display' : 'block'
  });
  $("#imp-bg-fade").css("display", "");
  setTimeout(function() {
    $(".sidenav-home").css({
      'left' : '0px'
    });
    $("#imp-bg-fade").css("opacity", "");
  }, 400);
}



function hideSidenav(){

  var windowWidth = $(window).width();

  if(windowWidth >= 1200) {
    showSidenav();
    return;
  }
  $(".sidenav-home").css({
    'left' : '-500px'
  });
  $("#imp-bg-fade").css("display", "none");
  setTimeout(function() {
    $(".sidenav-home").css({
      'display' : 'none'
    });
    $("#imp-bg-fade").css("opacity", "0");
  }, 400);
}

// function expandRec(){
//   // make sure all of this applies to only the element expanded
//   $(".expand-rec-section").css({
//     'height' : recHeight + 420 + 'px';
//   });
//   recHeight += 420;
// }

function removeDragData(ev) {
  if (ev.dataTransfer.items) {
    ev.dataTransfer.items.clear();
  } else {
    ev.dataTransfer.clearData();
  }
}

function libDrop(ev) {
  ev.preventDefault();
  var files = ev.dataTransfer.files;
  for (var i = 0; i < files.length; i++) {
    var file = files[i];
    var nameSplit = file.name.split(".");
    uploadFile(file, null, nameSplit[nameSplit.length - 1], -1, ev.srcElement.dataset.id);
  }

  removeDragData(ev);
  $(ev.srcElement).removeClass("is-dragover");
}

function libDrag(ev) {
  ev.preventDefault();
  $(ev.srcElement).addClass("is-dragover");
}

function libDragLeave(ev) {
  ev.preventDefault();
  $(ev.srcElement).removeClass("is-dragover");
}
