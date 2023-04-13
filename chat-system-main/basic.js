/****************************
 *  fucntion all_chats fetches all the chats from SESSIONS table in the left side panl;
 * it does so by an ajax call which sends a 
 * **************************** */
function all_chats() {
    const element = $(".chat_list");
    $.ajax({
        type: "POST",
        url: "ajax.php",
        // dataType: "text",
        // async: false,
        data: "function=all_chats",
        // contentType: "application/json; charset=utf-8",
        success: function (data) {

            unread_chatlist = JSON.parse(data);

            var count = (unread_chatlist).length;

            for (let i = 0; i < (count); i++) {

                $(element).append(`<div class="contact" data-chat="${i}" id=${unread_chatlist[i].session_id}><img src="img/user.png" alt="openchat"><div class="name" }><h4 class="firstname" }>${unread_chatlist[i].receiver}</h4><small class="message_time" }>${timestamp(unread_chatlist[i].timestamp)}</small><br><small class="sentence" }>${unread_chatlist[i].last_msg}</small></div></div>`);

            }

        },
        error: function (textStatus, errorThrown) {
            console.log("error");

        }
    });


}

/****************************************** 
 *  timestamp function takes input datetime in format "2023-03-29 18:54:25"  and returns date as "2023-03-09" if its not todays date OR returns time as "19:45" if its todays date; 
 * its used in the left side panel to show either the time (for today's date) or date for messages fetched as all chats
*******************************************/
function timestamp(datetime) {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;

    date = datetime.substr(0, 11);
    time = datetime.substr(11, 5);
    //  console.log("today : " + today); console.log("date : " + date); console.log("time :" + time); console.log("local: " + ((today).trim()).localeCompare((date).trim()));

    if (((today).trim()).localeCompare((date).trim()) != 0) {
        //         console.log("equal"); 
        date = datetime.substr(0, 11);
        return date;
    }
    else {
        // console.log("no0");
        time = datetime.substr(11, 5);
        return time;
    }
}


/****************************************** 
 * opens an chat messages (conovo) in right panel based on session id  
 * 
 **********************************************************************************/
function open_chat(session_id, data_chat) {
    // event.preventDefault();

    var currently_active = document.getElementsByClassName("active");
    if (currently_active.length > 0) {
        $(".message_box").remove();
        // document.getElementsByClassName('message_box').innerHTML = " ";
    }



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


}

function update_chat(session_id) {
    
  

    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: "function=open_chat&session_id=" + session_id,
        success: function (data) {

            open_cht = JSON.parse(data);
            var count = (open_cht).length;

            for (let i = 0; i < count; i++) {

                $(".message_box").append(`  
                <div class="message ${(open_cht[i].is_outgoing == 1) ? 'green' : 'white'}"><p>${open_cht[i].msg}</p><h6>for counter :
                ${i}</h6><i class="fas fa-chevron-down"></i><div class="message_dropdown"><div class="message_options"><div class="message_info">Info</div><div class="message_delete">Delete</div></div></div></div>
              `);

            }

            $('.message_box').scrollTop($(document).height());
        },
        error: function (textStatus, errorThrown) {
            console.log("error");

        }
    });
}