
<style>
  .addElement {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 999;
    border-radius: 50%;
    width: 70px;
    height: 70px;
  }

  .grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;

  }
</style>
<button type="button" class="btn btn-danger addElement" id="btn-add-images" data-bs-toggle="modal" data-bs-target="#exampleModal">
  <i class="fa-solid fa-plus"></i>
</button>




<div class="container-fluid speaker">

<a class="btn btn-success" href="<?= base_url() . 'Designes.json' ?>">Download JSON</a>
<div class="grid gap-4 p-4">
  <?php $i=0;foreach ($images as $image) { ?>

      <div id="imageThumnail" class="col ps-3 pe-3 pt-2 feature Card">
        <img src="<?= $image['url'] ?>" class="img-thumbnail">
        <h3>
          <?= $image['name'] ?>
        </h3>
        <p id="idImage">
          <?= $image['id'] ?>
        </p>

        <div class="ImageTools notActive">
          <a href='<?= base_url() . 'deleteImage/' . $image['id'] ?>' class="btn btn-danger">Delete</a>
          <a href='<?= base_url() . 'consultImage/' . $image['id'] ?>' class="btn btn-primary">Modify</a>
        </div>
      </div>





  <?php $i++; } ?>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Image</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url() . 'createImage'?>" id="form-file" method="POST" enctype="multipart/form-data">
          <input type="file" name="image" id="image" placeholder="Image" class="form-control">
          <br>
          <h4>OR</h4>
          <br>
          <input type="text" name="url" id="url" placeholder="URL" class="form-control">
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-add-image">Create Image</button>
      </div>
    </div>
  </div>
</div>
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script type="module">
  document.addEventListener("DOMContentLoaded", function () {
    const getAllCards = document.querySelectorAll('.Card');
    getAllCards.forEach(card => {
      card.addEventListener('mouseover', () => {
        const getTools = card.querySelector('.ImageTools');
        getTools.classList.add('active');
        getTools.classList.remove('notActive');
      });


      //on mouse leave
      card.addEventListener('mouseleave', () => {
        const getTools = card.querySelector('.ImageTools');
        getTools.classList.remove('active');
        getTools.classList.add('notActive');
      });

      card.addEventListener('click', () => {
        let id = card.querySelector('#idImage').innerHTML;
        let idn = parseInt(id);
        console.log(idn);
        window.location.href = "<?= base_url() . 'show_images/' ?>" + idn;
      });

    });
  });


  const addImageButton =document.querySelector('#btn-add-image');

  addImageButton.addEventListener('click',()=> {
    
    const image = document.querySelector('#image').files[0];
    //image here is a input type file
    console.log(image);
    const url = document.querySelector('#url').value;

    if(image == undefined && url == ''){
      $("#image").notify("You must add at least one image", "error");
      $("#url").notify("You must add at least one image", "error");
      return;
    }else if (image != undefined && url != ''){
      $("#image").notify("You must add only one image", "error");
      $("#url").notify("You must add only one image", "error");
      return;
    }else{
      if(image != undefined){
        $('#form-file').attr('action','<?= base_url() . 'createImage'?>')
        $('#form-file').submit();
      }
      else{
        console.log('url');
        $('#form-file').attr('action','<?= base_url() . 'createImage'?>')
        $('#form-file').submit();
      }
    }

  })

</script>
