const gallery_wrap = document.querySelector(".gallery_wrap");
const gallery_item = document.querySelector(".gallery_item");
const image_full_view = document.querySelector(".image_full_view"); //image_full_view

gallery_wrap.addEventListener("click", function(event) {
    if (event.target.tagName.toLowerCase() === "img") {
        console.log(event.target.closest(".gallery_item").id);
        //sessionStorage.setItem("picture_id",document.querySelector(".gallery_item").id);
        
        const image_id = event.target.closest(".gallery_item").id;
        //window.location.href = "image.php?image_id="+image_id;
        image_full_view.showModal();
        if(image_full_view.open){
            fetch(`gallery_image_detail.php?image_id=${image_id}`)
                .then(response => response.json())
                .then(data => {
                    //console.log(data); // pole obrázkov

                    data.forEach(image => {
                        // Tu môžeš spracovať každý obrázok podľa potreby
                        // napr. console.log(image.picture_title);
                        console.log(image.picture_title);
                        console.log(image.picture_path);
                        document.querySelector(".image_full_view img").src = image.picture_path;
                        document.querySelector(".image_full_view .image-name").textContent = image.picture_title;
                    });
                });
          }
    }
}); 