<style>
.mainContainer{
    position: fixed;
    width: 100%;
    height: 100%;
    background-color: rgba(71, 71, 71, 0.414);
    z-index: 999;
    top: 0;
    left: 0;
    display: flex;
    justify-content: center;
    align-items: center;

}

.mainContainer img{
transform: scale(0.5);
    box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
}

#closeButton{
    position: absolute;
    top: 20px;
    right: 20px;
    z-index: 999;
}
</style>

<div class="mainContainer">
    <button class="btn btn-danger" id="closeButton">Close</button>
    <img id='imageThumnailX' class="rounded" src="<?= $image['url'] ?>" alt="">

</div>


<script>
    let closeButton = document.querySelector("#closeButton");
    closeButton.addEventListener("click", function(){
        window.location.href = "<?= base_url() . 'show_images' ?>";
    })

    let image = document.querySelector("#imageThumnailX");   
   //scale the image to 50% of the image size 
</script>