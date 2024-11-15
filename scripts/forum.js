document.querySelectorAll('textarea, #searchBar').forEach(element => {
    element.style.height = `${element.scrollHeight}px`;
    element.addEventListener('input', event => {
        if (parseFloat(event.target.style.height) > 100)
        {
            event.target.style.overflowY = 'scroll'
            return;
        }
        event.target.style.height = 'auto';
        event.target.style.height = `${event.target.scrollHeight}px`;
    })
})

let messageContainer = document.getElementById("channelMessages")

function AddMessage(channelName, postDate, text, replyId, playerId, playerName, channelId, replyText)
{
    var xmlhttp = new XMLHttpRequest();
    if (this.readyState == 4 && this.status == 200) {
        if (replyId != null)
        {
            let reply = document.createElement("div");
            reply.className = "reply";
            reply.innerHTML = "::: replying to " + playerName.substr(0, 10) + "... : " + replyText.substr(0, 20) + "...";
            reply.id = replyId
            messageContainer.appendChild(reply)
        }
        let message = document.createElement("div");
        message.className = "message";
        message.id = channelName + postDate + "/" + number
        message.innerHTML = text;
        message.dataset.reply = replyId
        let br1 = document.createElement("br");
        let br2 = document.createElement("br");
        message.appendChild(br1)
        message.appendChild(br2)
        messageContainer.appendChild(message)
    }
    xmlhttp.open("GET", `./ajax/getDBData.php?request=
      INSERT INTO message (id, text, reply, owner, postDate, channelId)
      VALUES (
        '`+ channelName + postDate + "/" + number + "', '"
        + text + "', "
        + replyId + ", "
        + playerId + ", '"
        + postDate + "', "
        + channelId
        + ")", true);
    xmlhttp.send();
}


function getMessages(channelId) {
    console.log(channelId)
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            messageData = JSON.parse(this.responseText);
            console.log(messageData)

            let title = document.createElement("h2");
            title.innerHTML = messageData[0]["title"];
            title.className = "message";
            title.id = "title";
            messageContainer.appendChild(title)
            messageContainer.appendChild(document.createElement("br"))
            messageContainer.appendChild(document.createElement("br"))
            
            for (let i = 0; i < messageData.length; ++i)
            {
                if (messageData[i]["reply"] != null)
                {
                    let reply = document.createElement("div");
                    reply.className = "reply";
                    reply.innerHTML = "::: replying to " + messageData[i]["replyNickname"].substr(0, 10) + "... : " + messageData[i]["replyText"].substr(0, 20) + "...";
                    reply.id = messageData[i]["replyId"]
                    messageContainer.appendChild(reply)
                }
                let message = document.createElement("div");
                message.className = "message";
                message.id = messageData[i]["id"]
                message.innerHTML = messageData[i]["text"];
                message.dataset.reply = messageData[i]["reply"]
                let br1 = document.createElement("br");
                let br2 = document.createElement("br");
                message.appendChild(br1)
                message.appendChild(br2)

                messageContainer.appendChild(message)
            }
            
        }
    }
    xmlhttp.open("GET", `./ajax/getDBData.php?request=
      SELECT
      channel.title,
      message.id,
      message.text,
      message.reply,
      reply.id AS replyId,
      reply.text AS replyText,
      player.nickname AS replyNickname 
      FROM message 
      LEFT JOIN message AS reply ON message.reply = reply.id 
      LEFT JOIN player ON reply.owner = player.id 
      LEFT JOIN channel ON message.channelId = channel.id 
      WHERE message.channelId = ` + channelId + " ORDER BY message.postDate", true);
    xmlhttp.send();
}

function changeTheme(theme) {
    messageContainer.innerHTML = "";
    getMessages(theme.dataset.channelid)
}


recentlist = [];
themeList = [...document.getElementsByClassName("theme")];
console.log(document.getElementsByClassName("theme"))
themeList.forEach(theme => {
    theme.addEventListener("click", (e) => { changeTheme(e.target) })
    if (recentlist.length > 20)
        return;
    recentlist.push(theme);
})
console.log(themeList)
function filter() {
    themeList.forEach(theme => {
        theme.style.display = "none";
    });
    let searchBar = document.getElementById('themeSearchbar')
    console.log(searchBar)
    searchBar = searchBar.value.toLowerCase();
    console.log(searchBar)
    if (searchBar == '') {
        recentlist.forEach(theme => { theme.style.display = "block" })
    }
    else {
        themeList.forEach(theme => {
            if (typeof theme != "object") return;
            console.log(theme, theme.dataset.keywords)
            if (theme.innerHTML.toLowerCase().includes(searchBar) || (theme.dataset.keywords).toLowerCase().includes(searchBar))
                theme.style.display = "block";
        })
    }
}

document.getElementById('themeSearchbar').addEventListener('input', filter);


document.getElementById('submitMessage').addEventListener('click', () => {
    let channelName = document.getElementById("title").innerHTML;
    const currentDate = new Date();
    const dateString = currentDate.toLocaleString();
    console.log(dateString)

    // AddMessage();
});

