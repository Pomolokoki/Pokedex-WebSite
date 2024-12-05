let currentChannel = 1;
let creatingTheme = false;
document.querySelectorAll('textarea, #searchBar').forEach(element => {
    element.style.height = `${element.scrollHeight}px`;
    element.addEventListener('input', event => {
        if (parseFloat(event.target.style.height) > 100 && event.target.scrollHeight > 100) {
            return;
        }
        event.target.style.height = 'auto';
        event.target.style.height = `${event.target.scrollHeight}px`;
        if (event.target.id = "messageTextBox")
        {
            document.getElementById("channel").style.paddingBottom = event.target.style.height;
        }
        if (parseFloat(event.target.style.height) > 100) {
            event.target.style.overflowY = 'scroll'
        }
    })
})

let messageContainer = document.getElementById("channelMessages")

function toMessage(id) {
    let msg = document.getElementById(id);
    msg.scrollIntoView({ behavior: "smooth" });
    // msg.style.transition = 'background-color 0s'
    // msg.style.backgroundColor = 'rgb(65, 65, 65)';
    // msg.style.transition = 'background-color 5s'
    // msg.style.backgroundColor = 'black';
    // msg.style.animation = 'animation: colorchange 4s 1';
    msg.classList.remove("selectAnimation")
    void msg.offsetWidth
    msg.classList.add("selectAnimation")
}

function AddMessage(messageId, owner, picture, nickname, text, replyId, replyOwner, replyPicture, replyNickname, replyText) {
    let profile = document.createElement("div");
    profile.className = "profile";
    messageContainer.appendChild(profile)
    let profilePicture = document.createElement("img");
    profilePicture.className = "profilePicture";
    profilePicture.src = picture;
    profilePicture.alt = "profilePicture";
    profile.appendChild(profilePicture)
    let name = document.createElement("label")
    name.innerHTML = nickname;
    profile.appendChild(name)

    if (replyId != null) {
        let reply = document.createElement("div");
        reply.className = "reply";
        reply.innerHTML = "::: replying to <img class=profilePicture src = " + replyPicture + " alt=profilePicture>" + replyNickname.substr(0, 10) + "... : " + replyText.substr(0, 20) + "...";
        reply.dataset.id = replyId
        reply.dataset.owner = replyOwner
        messageContainer.appendChild(reply)
        reply.addEventListener("click", () => { toMessage(reply.dataset.id) })
    }
    let message = document.createElement("div");
    message.className = "message";
    message.id = messageId
    message.innerHTML = text;
    message.dataset.reply = replyId;
    message.dataset.owner = owner;
    messageContainer.appendChild(message)


    let br1 = document.createElement("br");
    let br2 = document.createElement("br");
    message.appendChild(br1)
    message.appendChild(br2)

    message.addEventListener("mouseenter", showOption)
    message.addEventListener("mouseleave", hideOption)
}

function AddMessageToDB(postDate, text, replyId, playerId, channelId) {
    let id
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {

        var xmlhttp2 = new XMLHttpRequest();
        xmlhttp2.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                id = JSON.parse(this.responseText)[0]["id"];
            }
        }
        xmlhttp2.open("GET", "./ajax/getDBData.php?request=SELECT id, MAX(postDate) FROM message", false);
        xmlhttp2.send();
    }
    console.log(`INSERT INTO message (id, text, reply, owner, postDate, channelId)
    VALUES (
      'UUID(),`
      + text + "', "
      + replyId + ", "
      + playerId + ", '"
      + postDate + "', "
      + channelId
      + ");")
    xmlhttp.open("GET", `./ajax/getDBData.php?request=
      INSERT INTO message (id, text, reply, owner, postDate, channelId)
      VALUES (
        UUID(),'`
        + text + "', "
        + replyId + ", "
        + playerId + ", '"
        + postDate + "', "
        + channelId
        + ");", false);
    xmlhttp.send();
    return id;
}

function getPlayerInfo(id) {
    var datas
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let data = JSON.parse(this.responseText)[0]
            datas = [data[0], data[1]]
        }
    }
    xmlhttp.open("GET", "./ajax/getDBData.php?request=SELECT picture, nickname FROM player WHERE id = " + id, false);
    xmlhttp.send();
    return datas
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


            for (let i = 0; i < messageData.length; ++i) {
                AddMessage(messageData[i]["id"],
                    messageData[i]["owner"],
                    messageData[i]["picture"],
                    messageData[i]["nickname"],
                    messageData[i]["text"],
                    messageData[i]["replyId"],
                    messageData[i]["replyOwner"],
                    messageData[i]["replyPicture"],
                    messageData[i]["replyNickname"],
                    messageData[i]["replyText"]
                );
            }

        }
    }
    xmlhttp.open("GET", `./ajax/getDBData.php?request=
      SELECT
      channel.title,
      message.id,
      message.text,
      message.reply,
      player.id AS owner, 
      player.nickname,
      player.picture,
      reply.id AS replyId,
      reply.owner AS replyOwner,
      reply.text AS replyText,
      replyPlayer.nickname AS replyNickname,
      replyPlayer.picture AS replyPicture 
      FROM message 
      LEFT JOIN message AS reply ON message.reply = reply.id 
      LEFT JOIN player ON message.owner = player.id 
      LEFT JOIN player AS replyPlayer ON reply.owner = replyPlayer.id 
      LEFT JOIN channel ON message.channelId = channel.id 
      WHERE message.channelId = ` + channelId + " ORDER BY message.postDate", true);
    xmlhttp.send();
}



function removeMessage(message)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", `./ajax/getDBData.php?request=
        DELETE FROM message WHERE id='` + message.id + "'");
    xmlhttp.send();
    message.previousElementSibling.remove();
    message.remove();
}
function updateMessage(message)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", `./ajax/getDBData.php?request=
        UPDATE message SET text = '` + message.innerHTML.substr(0, message.innerHTML.length) + `' WHERE id='` + message.id + "'");
    xmlhttp.send();
    console.log("UPDATE message SET text = '" + message.innerHTML.substr(0, message.innerHTML.length) + `' WHERE id='` + message.id + "'")
}

function changeTheme(theme) {
    messageContainer.innerHTML = "";
    getMessages(theme.dataset.channelid)
    currentChannel = theme.dataset.channelid
}


recentlist = [];
themeList = [...document.getElementsByClassName("theme")];
console.log(document.getElementsByClassName("theme"))
themeList.forEach(theme => {
    if (theme.id == "createTheme")
        return;
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

let sendMessageButton = document.getElementById('submitMessage');
const playerValues = document.getElementById("data");
if (sendMessageButton) {
    sendMessageButton.addEventListener('click', () => {
        if (typing.innerHTML == "Modification du message")
        {   
            let message = document.getElementById(typing.dataset.message);
            message.innerHTML = messageArea.value;
            if (message.innerHTML.substr(0, message.innerHTML.length) == "")
            {
                typing.innerHTML = "";
                removeMessage(message);
                return;
            }
            typing.innerHTML = "";
            updateMessage(message);
            return;
        }
        const currentDate = new Date();
        let date = currentDate.toLocaleDateString().split("/").reverse().join("/") + " " + currentDate.toLocaleTimeString()
        let text = document.getElementById("messageTextBox").value;
        let playerId = playerValues == null ? playerValues : playerValues.dataset.id;
        let playerPicture, playerName
        [playerPicture, playerName] = playerId == null ? [null, null] : [...getPlayerInfo(playerId)]
        let channelId = currentChannel;
        let replyId = typing.innerHTML.startsWith("Répondre à ") ? replyId = typing.dataset.message : null;
        let replyOwner = replyId == null ? null : document.getElementById("replyId").dataset.owner
        let replyPicture, replyName
        [replyPicture, replyName] = replyId == null ? [null, null] : getPlayerInfo(replyOwner)
        let replyText = replyId == null ? null : document.getElementById("replyId").innerHTML;
        AddMessage(
            AddMessageToDB(date, text, replyId, playerId, channelId),
            playerId, 
            playerPicture,
            playerName,
            text,
            replyId,
            replyOwner,
            replyPicture,
            replyName,
            replyText
        );
        typing.innerHTML = "";
        // AddMessage(channelName, date, text, replyId, playerId, playerName, channelId, replyText);
    });
}

[...document.getElementsByClassName("reply")].forEach(message => {
    message.addEventListener("click", () => { toMessage(message.dataset.id) })
})

document.addEventListener("keydown", (e) => {
    let messageBox = document.getElementById("messageTextBox");
    if (messageBox != null && e.key.length === 1 && e.target != "themeSearchbar" && e.target != "messageTextBox") {
        messageBox.focus();
    }
})

let noFavTheme = document.getElementById('toConnect');
if (noFavTheme) {
    noFavTheme.addEventListener('click', () => {
        document.location.href = 'login.php';
    });
}



let messageArea = document.getElementById("messageTextBox");
let typing = document.getElementById("typing");

document.getElementById("createTheme").addEventListener("click", () => {
    messageContainer.innerHTML = "";
    creatingTheme = true;
    let title = document.createElement("h2");
    title.className = "message";
    title.id = "title";
    title.innerHTML = "Nouveau theme";
    typing.innerHTML = "Titre du nouveau thème";
    messageContainer.appendChild(title);
    messageContainer.appendChild(document.createElement("br"));
    messageContainer.appendChild(document.createElement("br"));
});

messageArea.addEventListener("input", (e) => {
    if (typing.innerHTML == "Titre du nouveau thème")
    {
        document.getElementById("title").innerHTML = e.target.value;
    }
});

typing.addEventListener('click', () => { typing.innerHTML=""})


















let optionsTrigger = document.getElementById("optionsTrigger")
let optionsMenu = document.getElementById("optionsMenu")
function showOption(e)
{
    e.target.appendChild(optionsTrigger);
    // optionsTrigger.style.left = e.target.getAttribute("left")
    // optionsTrigger.style.top = e.target.getAttribute("top")
    optionsTrigger.style.display = "unset";
}
function hideOption()
{
    optionsTrigger.style.display = "none";
    optionsMenu.style.display = "none";
}

[...document.getElementsByClassName("message")].forEach(message => {
    message.addEventListener("mouseenter", showOption)
    message.addEventListener("mouseleave", hideOption)
})

optionsTrigger.addEventListener("click", () => {
    optionsMenu.style.display = "unset";
})

let confirmAction = document.getElementById("confirmAction"); //ned to create
let confirmBox = document.getElementById("confirmBox"); //ned to create
let confirmText = document.getElementById("confirmText"); //ned to create
let confirmBut1 = document.getElementById("confirmBut1"); //ned to create
let confirmBut2 = document.getElementById("confirmBut2"); //ned to create

document.getElementById("editOption").addEventListener("click", () => {;
    let message =  optionsTrigger.parentNode;
    if (message.dataset.owner != playerValues.dataset.id)
        return;
    typing.innerHTML = "Modification du message";
    typing.dataset.message = message.id;
    // console.log(message)
    document.getElementById("channelMessages").appendChild(optionsTrigger);
    console.log(message.innerHTML.length)
    messageArea.value = message.innerHTML.substr(0, message.innerHTML.length);
    messageArea.style.height = 'auto';
    messageArea.style.height = `${messageArea.scrollHeight}px`;
    if (parseFloat(messageArea.style.height) > 100) {
        messageArea.style.overflowY = 'scroll'
    }
    hideOption();
})
document.getElementById("deleteOption").addEventListener("click", () => {
    let message = optionsTrigger.parentNode;
    if (message.dataset.owner != playerValues.dataset.id && playerValues.dataset.rank < 2)
        return;
    confirmText.innerHTML = "Supprimer le message ?";
    confirmAction.style.display = "unset";
    confirmBox.style.display = "unset";
    confirmBut1.addEventListener('click', () => {
        console.log(message)
        removeMessage(message);
        
        confirmAction.style.display = "none";
        confirmBox.style.display = "none";
    })
    confirmBut2.addEventListener('click', () => {
        confirmAction.style.display = "none";
        confirmBox.style.display = "none";
    })
    hideOption();
})
document.getElementById("answerOption").addEventListener("click", () => {
    let message =  optionsTrigger.parentNode;
    let profile = message.previousElementSibling;
    let owner = profile.children[1];
    document.getElementById("channelMessages").appendChild(optionsTrigger);
    typing.innerHTML = "Répondre à : " + owner.innerHTML;
    typing.dataset.message = message.id;
    hideOption();
})
document.getElementById("reportOption").addEventListener("click", () => {
    alert("Does Nothing Yet");
    hideOption();
})

// console.log(document.cookie)
