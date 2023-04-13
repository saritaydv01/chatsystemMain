<?php include("dbcon.php"); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
    integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <script src="basic.js"></script>
  <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
  <link rel="stylesheet" href="boolzapp.css">
  <title>Chat system</title>
</head>

<body>
  <header>
    <div class="header_left">
      <img src="img/user.png" alt="profile">
     
      <h3 class="user_firstnm">Hema</h4> 
      <div class="icons_left">
      
        <i class="fas fa-circle-notch" title="Logout"></i>
        <!-- <i class="fas fa-comment-alt"></i> -->
        <!-- <i class="fas fa-ellipsis-v"></i> -->
      </div>
    </div>

    <div class="header_right" style="opacity: 0;">
      <img src="img/user.png" alt="openchat">
      <div class="name">
        <h2 class="firstname"></h2> 
        <small>Last seen today at <span class="message_time">18:30</span></small>
      </div>
      <div class="icons_right">
        <!-- <i class="fas fa-search"></i> -->
        <!-- <i class="fas fa-paperclip"></i>
        <i class="fas fa-ellipsis-v"></i> -->
      </div>
    </div>
  </header>

  <div class="b">
    <section>

      <div class="container_left">
        <div class="search_bar">
          <i class="fas fa-search"></i>
          <input class="searchme" type="text" placeholder="Search or start new chat">
        </div>
        <div class="chat_list" id="chat_list">

          <!-- <div class="contact active" data-chat="0">
          <img src="img/user.png" alt="openchat">
          <div class="name">
            <h4 class="firstname">Socrates</h4><small class="message_time">06:35</small><br>
            <small class="sentence">True knowledge exists in knowing that you know nothing</small>
          </div>
        </div> -->



        </div>
      </div>












      
<div class="container_right">
        <div class="message_container">
          <!-- <div class="message_box " data-chat="0">
          <div class="message white">
            <p>data-chat="0"</p>
            <h6>05:15</h6><i class="fas fa-chevron-down"></i>
            <div class="message_dropdown">
              <div class="message_options">
                <div class="message_info">Info</div>
                <div class="message_delete">Delete</div>
              </div>
            </div>
          </div>

          <div class="message green">
            <p>Imagination is moredata-chat="0"</p>
            <h6>05:30</h6><i class="fas fa-chevron-down"></i>
            <div class="message_dropdown">
              <div class="message_options">
                <div class="message_info">Info</div>
                <div class="message_delete">Delete</div>
              </div>
            </div>
          </div>
        </div> -->

        </div>

        <footer>
          <div class="type_message">
            <!-- <i class="fas fa-smile"></i> -->
            <input class="type_here" type="text" placeholder="Type a message">
            <i class="fas fa-paper-plane"></i>
            <!-- <i class="fas fa-microphone"></i> -->
          </div>
        </footer>
      </div>
<!-- -------------------------------------------------------------------------------------------------- -->
<!-- <iframe src="ifram.php" frameborder="10"></iframe> -->
    </section>
  </div>
  <div class="template">
    <div class="message green">
      <p class="content">Something new</p>
      <h6 class="message_time">5:55</h6><i class="fas fa-chevron-down"></i>
      <div class="message_dropdown">
        <div class="message_options">
          <div class="message_info">Info</div>
          <div class="message_delete">Delete</div>
        </div>
      </div>
    </div>
  </div>

  <script src="boolzapp.js" charset="utf-8"></script>
  <script>
    $(document).ready(function () {
      all_chats();

    });

    /**
     * find the nearest div and session_id stores its ID 
     */
    $('.chat_list').on('click', '.contact', function (e) {

      var session_id = $(this).closest('div').attr('id');

      var data_chat = $(this).closest('div').attr('data-chat');


      var currently_active = document.getElementsByClassName("active");
      if (currently_active.length > 0) {
        currently_active[0].className = currently_active[0].className.replace(" active", "");
      }
      this.className += " active";

      open_chat(session_id, data_chat);

      // $(".message_box.active").hide();

      $.ajax({
        type: "POST",
        url: "ajax.php",
        data: "function=open_chat&session_id=" + session_id,
        success: function (data) {

          open_cht = JSON.parse(data);
          var count = (open_cht).length;

          $(".message_container").append(` <div class="message_box active" data-chat="">  </div>`);
          for (let i = 0; i < count; i++) {

            $(".message_container").closest('div').find('.message_box').attr("data-chat", data_chat);

            $(".message_box").append(`  
                <div class="message ${(open_cht[i].is_outgoing == 1) ? 'green' : 'white'}"><p>${open_cht[i].msg}</p><h6>for counter :${i}</h6><i class="fas fa-chevron-down"></i><div class="message_dropdown"><div class="message_options"><div class="message_info">Info</div><div class="message_delete">Delete</div></div></div></div>
              `);

          }

          $('.message_box').scrollTop($(document).height());
        },
        error: function (textStatus, errorThrown) {
          console.log("error");

        }
      });

    });

    $(document).ready(function () {

      // $('.chat_list').on('click', '.contact', function (e) {

      //   // var data_chat = $(this).closest('div').attr('data-chat');
      //   // var data_chat = $(this).closest('div').attr('id');

      // });

      setInterval(function () {
        // console.log("ready!");
        var session_id = $('.firstname').attr('id');
        var data_chat = $('.firstname').attr('data-chat');
        console.log(data_chat);
        
        open_chat(session_id, data_chat);
      }, 1000);
    });
  </script>
</body>

</html>