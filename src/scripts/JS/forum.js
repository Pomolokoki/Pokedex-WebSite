let currentChannel = 1;
let currentOffsetMessage = 0
let currentOffsetChannel = 0
let currentOffsetFavorite = 0
let creatingTheme = false;

// text area fit to content
document.querySelectorAll("textarea, #searchBar").forEach((element) => {
  element.style.height = 54 + `px`;
  element.addEventListener("input", (event) => {
    if (
      parseFloat(event.target.style.height) > 100 &&
      event.target.scrollHeight > 100
    ) {
      return;
    }
    event.target.style.height = "auto";
    event.target.style.height = `${event.target.scrollHeight}px`;
    if (event.target.id == "messageTextBox") {
      document.getElementById("channel").style.paddingBottom =
        event.target.style.height;
    }
    if (parseFloat(event.target.style.height) > 100) {
      event.target.style.overflowY = "scroll";
    }
  });
});

let messageContainer = document.getElementById("channelMessages");

// UUID to store in DB
async function getUUID() {
  const decodedJSON = await fetch(
    "../database/get/FromJS/getDBDataForum.php?request=UUID"
  ).then((res) => res.json());

  const id = decodedJSON[0]["uuid"];
  console.log("uuid : ", id, id.length);
  return id;
}

async function getPlayerInfo(id) {
  const decodedJSON = await fetch(
    "../database/get/FromJS/getDBDataForum.php?request=PlayerInfo&1=" + id
  ).then((res) => res.json());

  console.log(decodedJSON);
  const datas = [decodedJSON[0][0], decodedJSON[0][1]];
  console.log(datas);
  return datas;
}

// region message

document.getElementById("channel").addEventListener("scroll", async (e) => {
  if (e.target.scrollTop == 0) {
    getMessages(currentChannel, currentOffsetMessage)
  }
});

// scroll to message animation
function toMessage(id) {
  let msg = document.getElementById(id);
  msg.scrollIntoView({ behavior: "smooth" });
  msg.classList.remove("selectAnimation");
  void msg.offsetWidth;
  msg.classList.add("selectAnimation");
}

// add message into the channel
function AddMessage(
  messageId,
  owner,
  picture,
  nickname,
  text,
  replyId,
  replyOwner,
  replyPicture,
  replyNickname,
  replyText
) {
  let profile = document.createElement("div");
  profile.className = "profile";
  messageContainer.appendChild(profile);

  let profilePicture = document.createElement("img");
  profilePicture.className = "profilePicture";
  profilePicture.src = picture == "emptyPicture.png" ? "../../public/img/" + picture : picture;
  profilePicture.alt = "photo de profil";
  profilePicture.loadding = lazy
  profilePicture.decoding = async
  profile.appendChild(profilePicture);

  let name = document.createElement("label");
  name.innerHTML = nickname;
  profile.appendChild(name);

  if (replyId != null) {
    let reply = document.createElement("div");
    reply.className = "reply";
    reply.innerHTML =
      "::: replying to <img class=profilePicture src = " +
      replyPicture == "emptyPicture.png" ? "../../public/img/" + replyPicture : replyPicture +
      " alt=photo de profil loading=lazy decoding=async>" +
      replyNickname.substr(0, 10) +
      "... : " +
      replyText.substr(0, 20) +
      "...";
    reply.dataset.id = replyId;
    reply.dataset.owner = replyOwner;
    messageContainer.appendChild(reply);
    reply.addEventListener("click", () => {
      toMessage(reply.dataset.id);
    });
  }

  let message = document.createElement("div");
  message.className = "message";
  message.id = messageId;
  message.innerHTML = text;
  message.dataset.reply = replyId;
  message.dataset.owner = owner;
  messageContainer.appendChild(message);

  let br1 = document.createElement("br");
  let br2 = document.createElement("br");
  message.appendChild(br1);
  message.appendChild(br2);

  message.addEventListener("mouseenter", showOption);
  message.addEventListener("mouseleave", hideOption);
}

// add a new message into the DataBase
async function AddMessageToDB(
  id,
  text,
  replyId,
  playerId,
  channelId
) {
  fetch(
    "../database/get/FromJS/getDBDataForum.php?request=NewMessage&1=" +
      id +
      "&2=" +
      text +
      "&3=" +
      replyId +
      "&4=" +
      playerId +
      "&5=" +
      channelId
  );
}

// region theme
// add a new channel into the DataBase
async function AddChannelToDB(id, owner, title, keyWords) {
  fetch(
    "../database/get/FromJS/getDBDataForum.php?request=NewChannel&1=" +
      id +
      "&2=" +
      owner +
      "&3=" +
      title +
      "&4=" +
      keyWords
  );
}

//get favorite themes
let channel = [];
let sendMessageButton = document.getElementById("submitMessage");
let messageBox = document.getElementById("messageTextBox");
let typing = document.getElementById("typing");

async function getFavorites(playerId) {
  const decodedJSON = await fetch(
    "../database/get/FromJS/getDBDataForum.php?request=GetFavs&1=" + playerId + "&2=" + currentOffsetFavorite
  ).then((res) => res.json());

  const data = decodedJSON[0];
  if (data == "No results found.") return [];
  return data;
}

async function getFavorite(playerId, themeId) {
  const decodedJSON = await fetch(
    "../database/get/FromJS/getDBDataForum.php?request=GetFav&1=" +
      playerId +
      "&2=" +
      themeId
  ).then((res) => res.json());
  const bool = decodedJSON[0] == "No results found.";

  return bool;
}

// is it fovrited theme (set svg star)
async function isFavorite(themeId) {
  if (playerValues) {
    let isFav = await getFavorite(playerValues.dataset.id, themeId);
    if (isFav) {
      setFav.dataset.selected = true;
      setFav.innerHTML = filledStar;
    } else {
      setFav.dataset.selected = false;
      setFav.innerHTML = emptyStar;
    }
  }
}

// get messages from a channel into the DB
async function getMessages(channelId, offset) {
  
  const decodedJSON = await fetch(
    "../database/get/FromJS/getDBDataForum.php?request=GetMessages&1=" +
      channelId +
      "&2=" +
      Number(offset)
  ).then((res) => res.json());
  if (decodedJSON == "No results found.") return; // no message found which is impossible because theme should have a start message
  const messageData = decodedJSON;
  if (offset == 0) {
    messageContainer.innerHTML = "";

    const title = document.createElement("h2");
    title.innerHTML = messageData[0]["title"];
    title.className = "message";
    title.dataset.owner = messageData[0]["owner"];
    title.id = "title";
    messageContainer.appendChild(title);
    messageContainer.appendChild(document.createElement("br"));
    messageContainer.appendChild(document.createElement("br"));
  }

  for (let i = 0; i < messageData.length; ++i) {
    AddMessage(
      messageData[i]["id"],
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

// change theme
let channelDiv = document.getElementById("channel");
let themesDiv = document.getElementById("themes");
let arrow = document.getElementById("mobileBackArrow");
function changeTheme(theme) {
  if (window.innerWidth < 600) {
    channelDiv.style.display = "unset";
    themesDiv.style.display = "none";
    arrow.style.display = "unset";
  }
  isFavorite(theme.dataset.channelid);
  currentChannel = theme.dataset.channelid;
  currentOffsetMessage = 0
  getMessages(theme.dataset.channelid, currentOffsetMessage);
}

recentlist = [];
themeList = [...document.getElementsByClassName("theme")];
// init
themeList.forEach((theme) => {
  if (theme.id == "createTheme") return;
  theme.addEventListener("click", (e) => {
    changeTheme(e.target);
  });
  if (recentlist.length > 25) return;
  recentlist.push(theme);
});

function addThemeInList(id, keywords, favorite, title, parent) {
    let themeDiv = document.createElement("div")
    themeDiv.className = "theme"
    themeDiv.dataset.channelId = id
    themeDiv.dataset.keywords = keywords
    themeDiv.dataset.favorite = favorite
    themeDiv.innerHTML = title
    parent.appendChild(themeDiv)
}

// filter for search bar
async function filter() {


  let searchBar = document.getElementById("themeSearchbar").value.toLowerCase();
  if (selectFav && selectFav.dataset.selected == "true") {
    let themeList = getFavorites(playerValues.dataset.id)
    document.getElementById("themeResults").innerHTML = ""
    themeList.forEach((theme) => {
        addThemeInList(theme.id, theme.keywords, getFavorite(theme.id), theme.title, document.getElementById("themeResults"))
    });

  } else if (searchBar == "") {
    let themeList = await fetch("../database/get/FromJS/getDBDataForum.php?request=GetChannels&1=" + currentOffsetChannel).then((res) => res.json());
    console.log(themeList)
    document.getElementById("themeResults").innerHTML = ""
    themeList.forEach((theme) => {
        addThemeInList(theme.id, theme.keywords, getFavorite(theme.id), theme.title, document.getElementById("themeResults"))
    });

  } else {
    let themeList = await fetch("../database/get/FromJS/getDBDataForum.php?request=SearchChannel&1=" + searchBar + "&2=" + currentOffsetChannel).then((res) => res.json());
    console.log(themeList)
    document.getElementById("themeResults").innerHTML = ""
    themeList.forEach((theme) => {
        addThemeInList(theme.id, theme.keywords, getFavorite(theme.id), theme.title, document.getElementById("themeResults"))
    });
  }
}
document.getElementById("themeSearchbar").addEventListener("input", filter);

// new theme
let createTheme = document.getElementById("createTheme");
if (createTheme) {
  createTheme.addEventListener("click", () => {
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
}
if (messageBox) {
  messageBox.addEventListener("input", (e) => {
    if (typing.innerHTML == "Titre du nouveau thème") {
      document.getElementById("title").innerHTML = e.target.value;
    }
  });
}
if (typing) {
  typing.addEventListener("click", () => {
    if (
      typing.innerHTML == "KeyWords (separate by /)" ||
      typing.innerHTML == "Message d'introduction"
    )
      changeTheme(currentChannel);
    typing.innerHTML = "";
  });
}

// add theme to favorite
async function setFavoriteTheme(bool) {
  const query = bool
    ? "AddFav&1=" + playerValues.dataset.id + "&2=" + currentChannel
    : "RemoveFav&1=" + playerValues.dataset.id + "&2=" + currentChannel;
  fetch("../database/get/FromJS/getDBDataForum.php?request=" + query);
}

let setFav = document.getElementById("setFavorite");
let selectFav = document.getElementById("selectFavorite");
if (setFav) {
  setFav.addEventListener("click", () => {
    if (setFav.dataset.selected == "false") {
      setFav.innerHTML = filledStar;
      setFav.dataset.selected = "true";
      setFavoriteTheme(true);
    } else {
      setFav.innerHTML = emptyStar;
      setFav.dataset.selected = "false";
      setFavoriteTheme(false);
    }
  });
}
if (selectFav) {
  selectFav.addEventListener("click", async () => {
    if (selectFav.dataset.selected == "false") {
      selectFav.innerHTML = filledStar;
      selectFav.dataset.selected = "true";
      let themes = document.getElementsByClassName("theme");
      for (let i = 0; i < themes.length; ++i) {
        if (typeof themes[i] != "object") continue;
        console.log(playerValues.dataset.id, themes[i].dataset.channelid);
        if (
          themes[i].id == "createTheme" ||
          (await getFavorite(
            playerValues.dataset.id,
            themes[i].dataset.channelid
          ))
        )
          themes[i].style.display = "";
        else themes[i].style.display = "none";
      }
    } else {
      selectFav.innerHTML = emptyStar;
      selectFav.dataset.selected = "false";
      let themes = document.getElementsByClassName("theme");
      for (let i = 0; i < themes.length; ++i) {
        if (typeof themes[i] != "object") continue;
        themes[i].style.display = "";
      }
    }
  });
}

// region Send message

// send messge buitton click
const playerValues = document.getElementById("data");
if (sendMessageButton) {
  sendMessageButton.addEventListener("click", async () => {
    if (typing.innerHTML == "Modification du message") {
      // are we editing message ?
      let message = document.getElementById(typing.dataset.message);
      message.innerHTML = messageBox.value;
      if (message.innerHTML.substr(0, message.innerHTML.length) == "") {
        typing.innerHTML = "";
        messageBox.value = "";
        removeMessage(message);
        return;
      }
      typing.innerHTML = "";
      messageBox.value = "";
      updateMessage(message);
      return;
    }

    // getting ready the data to save in DB
    const currentDate = new Date();
    let date =
      currentDate.toLocaleDateString().split("/").reverse().join("/") +
      " " +
      currentDate.toLocaleTimeString();
    let text = messageBox.value;
    let playerId =
      playerValues == null ? playerValues : playerValues.dataset.id;
    let playerPicture, playerName;
    [playerPicture, playerName] =
      playerId == null ? [null, null] : [...(await getPlayerInfo(playerId))];
    let channelId = currentChannel;
    let replyId = typing.innerHTML.startsWith("Répondre à ")
      ? typing.dataset.message
      : null;
    let replyOwner =
      replyId == null ? null : document.getElementById(replyId).dataset.owner;
    let replyPicture, replyName;
    [replyPicture, replyName] =
      replyId == null ? [null, null] : await getPlayerInfo(replyOwner);
    let replyText =
      replyId == null ? null : document.getElementById(replyId).innerHTML;

    if (typing.innerHTML == "Titre du nouveau thème") {
      // are we creating a new theme ?
      typing.innerHTML = "KeyWords (separate by /)";
      messageBox.value = "";
      return;
    }

    if (typing.innerHTML == "KeyWords (separate by /)") {
      // are we setting the keyWords for the theme
      channel = text.split("/");
      typing.innerHTML = "Message d'introduction";
      messageBox.value = "";
      return;
    }

    if (typing.innerHTML == "Message d'introduction") {
      // are we sending the first theme message ?
      let title = document.getElementById("title");
      title.dataset.owner = playerId;
      let id = await getUUID();
      AddChannelToDB(id, playerId, title.innerHTML, channel, date);
      typing.innerHTML = "";
      messageBox.value = "";
      currentChannel = id;
      currentOffsetMessage = 0
      channelId = id;
    }

    // are we sending a mesage into the channel
    let id = await getUUID();
    AddMessageToDB(id, date, text, replyId, playerId, channelId);
    AddMessage(
      id,
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
    messageBox.value = "";
    typing.innerHTML = "";
  });
}

[...document.getElementsByClassName("reply")].forEach((message) => {
  message.addEventListener("click", () => {
    toMessage(message.dataset.id);
  });
});

// remove message on DB
async function removeMessage(message) {
  if (playerValues == null) return;
  let scroll = message.scrollTop
  await fetch(
    "../database/get/FromJS/getDBDataForum.php?request=RemoveMessage&1=" +
      message.id +
      "&2=" +
      playerValues.dataset.id
  );
  for (let i = 0; i < currentOffsetMessage; i += 25) {
        getMessages(currentChannel, i);
    }
    document.getElementById("channel").scrollHeight = scroll;
}

// update message on DB
function updateMessage(message) {
  if (playerValues == null) return;
  fetch(
    "../database/get/FromJS/getDBDataForum.php?request=UpdateMessage&1=" +
      message.innerHTML.substr(0, message.innerHTML.length) +
      "&2=" +
      message.id +
      "&3=" +
      playerValues.dataset.id
  );
}

// press enter to send message
document.addEventListener("keydown", (e) => {
  if (e.key == "Enter") {
    if (!e.shiftKey) {
      sendMessageButton.dispatchEvent(new SubmitEvent("click"));
      messageBox.value = "";
      return false;
    }
  } else if (
    messageBox != null &&
    e.key.length === 1 &&
    e.target.id != "themeSearchbar" &&
    e.target.id != "messageTextBox"
  ) {
    messageBox.focus();
  }
});

// if no fav theme -> click on the fav theme box = redirection to connection
let noFavTheme = document.getElementById("toConnect");
if (noFavTheme) {
  noFavTheme.addEventListener("click", () => {
    document.location.href = "login.php";
  });
}

// region option menu
let optionsTrigger = document.getElementById("optionsTrigger");
let optionsMenu = document.getElementById("optionsMenu");
let editOption = document.getElementById("editOption");
let answerOption = document.getElementById("answerOption");
let deleteOption = document.getElementById("deleteOption");
let reportOption = document.getElementById("reportOption");

function showOption(e) {
  if (e.playerValues == null) return;
  editOption.style.display = "block";
  answerOption.style.display = "block";
  deleteOption.style.display = "block";
  reportOption.style.display = "block";
  if (e.target.id == "title") {
    answerOption.style.display = "none";
    if (
      e.target.dataset.owner != playerValues.dataset.id &&
      playerValues.dataset.rank < 2
    ) {
      editOption.style.display = "none";
      deleteOption.style.display = "none";
    }
  } else {
    if (e.target.dataset.owner != playerValues.dataset.id) {
      editOption.style.display = "none";
      if (playerValues.dataset.rank < 2) deleteOption.style.display = "none";
    }
  }
  e.target.appendChild(optionsTrigger);
  optionsTrigger.style.display = "unset";
}

function hideOption() {
  optionsTrigger.style.display = "none";
  optionsMenu.style.display = "none";
}

[...document.getElementsByClassName("message")].forEach((message) => {
  message.addEventListener("mouseenter", showOption);
  message.addEventListener("mouseleave", hideOption);
});

optionsTrigger.addEventListener("click", () => {
  optionsMenu.style.display = "unset";
});

let confirmAction = document.getElementById("confirmAction");
let confirmBox = document.getElementById("confirmBox");
let confirmText = document.getElementById("confirmText");
let confirmBut1 = document.getElementById("confirmBut1");
let confirmBut2 = document.getElementById("confirmBut2");

// editing message
document.getElementById("editOption").addEventListener("click", () => {
  let message = optionsTrigger.parentNode;
  if (message.dataset.owner != playerValues.dataset.id) return;
  typing.innerHTML = "Modification du message";
  typing.dataset.message = message.id;
  document.getElementById("channelMessages").appendChild(optionsTrigger);
  messageBox.value = message.innerHTML.substr(0, message.innerHTML.length);
  messageBox.style.height = "auto";
  messageBox.style.height = `${messageBox.scrollHeight}px`;
  if (parseFloat(messageBox.style.height) > 100) {
    messageBox.style.overflowY = "scroll";
  }
  hideOption();
});

// deleting message
document.getElementById("deleteOption").addEventListener("click", () => {
  let message = optionsTrigger.parentNode;
  if (
    message.dataset.owner != playerValues.dataset.id &&
    playerValues.dataset.rank < 2
  )
    return;
  confirmText.innerHTML = "Supprimer le message ?";
  confirmAction.style.display = "unset";
  confirmBox.style.display = "unset";
  confirmBut1.addEventListener("click", () => {
    console.log(message);
    removeMessage(message);

    confirmAction.style.display = "none";
    confirmBox.style.display = "none";
  });
  confirmBut2.addEventListener("click", () => {
    confirmAction.style.display = "none";
    confirmBox.style.display = "none";
  });
  hideOption();
});

// writing an answer to a message
document.getElementById("answerOption").addEventListener("click", () => {
  let message = optionsTrigger.parentNode;
  let profile = message.previousElementSibling;
  let owner = profile.children[1];
  document.getElementById("channelMessages").appendChild(optionsTrigger);
  typing.innerHTML = "Répondre à : " + owner.innerHTML;
  typing.dataset.message = message.id;
  hideOption();
});

document.getElementById("reportOption").addEventListener("click", () => {
  alert("Does Nothing Yet");
  hideOption();
});

// mobile stuff
arrow.addEventListener("click", () => {
  channelDiv.style.display = "none";
  themesDiv.style.display = "";
  arrow.style.display = "none";
});
