const add_news = document.querySelector(".add_news");
const modal_add_news = document.querySelector(".modal_add_news");

add_news.addEventListener("click", (event) => {
    if(event.target.tagName === "BUTTON" && event.target.name === "add_news"){
        modal_add_news.showModal();
    }
});


modal_add_news.addEventListener("click", (event) => {
    if(event.target.tagName === "BUTTON" && event.target.name === "close_modal"){
        modal_add_news.close();
    } else if (event.target.tagName === "BUTTON" && event.target.name === "submit_news"){
        const news_title = document.querySelector(".modal_add_news input[name='news_title']").value;
        const news_content = document.querySelector(".modal_add_news textarea[name='news_content']").value;
        AddNews(news_title, news_content);
        modal_add_news.close();
    }
});


function AddNews(title, content){
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/news.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(`title=${title}&content=${content}`);
}