const gallery_wrap = document.querySelector(".gallery_wrap");
const gallery_item = document.querySelector(".gallery_item");
const image_full_view = document.querySelector(".image_full_view"); //image_full_view

gallery_wrap.addEventListener("click", function(event) {
    if (event.target.tagName.toLowerCase() === "img") {
        console.log(event.target.closest(".gallery_item").id);
        //sessionStorage.setItem("picture_id",document.querySelector(".gallery_item").id);
        //image_full_view.showModal();
        const image_id = event.target.closest(".gallery_item").id;
        window.location.href = "image.php?image_id="+image_id;
    }
});    
