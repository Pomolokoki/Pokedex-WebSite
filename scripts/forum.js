document.querySelectorAll('textarea, #searchBar').forEach(element => {
    element.style.height = `${element.scrollHeight}px`;
    element.addEventListener('input', event => {
        event.target.style.height = 'auto';
        event.target.style.height = `${event.target.scrollHeight}px`;
    })
})

recentlist = [];
themeList = [...document.getElementsByClassName("theme")];
console.log(document.getElementsByClassName("theme"))
themeList.forEach(theme => {
    recentlist.push(theme);
})
console.log(themeList)
function filter()
{
    themeList.forEach(theme => {
        theme.style.display = "none";
    });
    let searchBar = document.getElementById('themeSearchbar')
    console.log(searchBar)
    searchBar = searchBar.value.toLowerCase();
    console.log(searchBar)
    if (searchBar == '')
    {
        recentlist.forEach(theme => { theme.style.display = "block"})
    }
    else
    {
        themeList.forEach(theme => {
            if (typeof theme != "object") return;
            console.log(theme, theme.dataset.keywords)
            if (theme.innerHTML.toLowerCase().includes(searchBar) || (theme.dataset.keywords).toLowerCase().includes(searchBar))
                theme.style.display = "block";
        })
    }
}

document.getElementById('themeSearchbar').addEventListener('input', filter);

