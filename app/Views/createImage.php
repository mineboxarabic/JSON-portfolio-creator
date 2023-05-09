<style>
    img{
        width: 300px;
        height: 300px;
        object-fit: cover;

    }
</style>
<div class="container">
    
 
    <img class="rounded mx-auto d-block" src="<?= $imageUrl ?>" alt="...">
    <h1><?php $imageName2 ?></h1>


    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Image name</span>
        </div>
        <input type="text" id="imagename" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="<?= $imageName?>">
    </div>



<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon3">URL</span>
  </div>
  <input type="text" class="form-control" id="imageurl" aria-describedby="basic-addon3" value="<?=$imageUrl?>">
</div>

    
<button class="saveButton btn btn-primary">
    <i class="fas fa-save"></i>
    Save
</button>
    
</div>


<script defer type="module">

    $(".saveButton").on('click', function(){
        console.log("save button clicked");
     

        $.ajax({
            url: '<?= base_url() . 'modifyImage'?>',
            method: 'POST',
            data: {
                id: <?= $imageId ?>,
                name: $("#imagename").val(),
                url: $("#imageurl").val(),
            },
            success: function(response){
                window.location.href = "<?= base_url() . 'show_images'?>";
            }

        })
    })

</script>