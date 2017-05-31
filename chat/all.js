var chat = {
  loadMsg: function () {
    $.get("/chat/chat.php", {}, function (data) {
      if (data["type"] == "success") {
        var arr = data["messages"];
        arr.forEach(function (item, i, arr) {
          var temp = "<div class=\"chat_message\">" +
            "<div class=\"from\">" + item["from"] + "</div>" +
            "<div class=\"time\">" + item["time"] + "</div>" +
            "<div class=\"text\">" + item["text"] + "</div>" +
            "</div>";
          $(".chat_inner").append(temp);
          $(".chat_inner").animate({ scrollTop: $(".chat_inner")[0].scrollHeight}, 1000);
        });
      }
    });
  },

  sendMsg: function () {
    var text = $("#text").val();

    $.post("/chat/send.php", {text: text}, function (data) {

      if(data['type'] == "success") {
        $("#text").val("");
      } else {
        alert(data["message"]);
      }
    });

    chat.loadMsg();
  }
};

setInterval(function () {
  chat.loadMsg();
}, 1000);