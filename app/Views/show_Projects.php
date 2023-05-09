
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
<button type="button" class="btn btn-danger addElement" id="btn-add-projects">
  <i class="fa-solid fa-plus"></i>
</button>




<div class="container-fluid speaker">

<a class="btn btn-success" href="<?= base_url() . 'Projects.json' ?>">Download JSON</a>
<div class="grid gap-4 p-4">
  <?php $i=0;foreach ($Projects as $project) { ?>

      <div id="projectThumnail" class="col ps-3 pe-3 pt-2 feature Card">
        <img src="<?= $project['Image'] ?>" class="img-thumbnail">
        <h3>
          <?= $project['Name'] ?>
        </h3>
        <p id="idProject">
          <?= $project['id'] ?>
        </p>

        <div class="ProjectTools notActive">
          <a href='<?= base_url() . 'deleteProject/' . $project['id'] ?>' class="btn btn-danger">Delete</a>
          <a href='<?= base_url() . 'consultProject/' . $project['id'] ?>' class="btn btn-primary">Modify</a>
        </div>
      </div>





  <?php $i++; } ?>
</div>





<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script type="module">
  document.addEventListener("DOMContentLoaded", function () {
    const getAllCards = document.querySelectorAll('.Card');
    getAllCards.forEach(card => {
      card.addEventListener('mouseover', () => {
        const getTools = card.querySelector('.ProjectTools');
        getTools.classList.add('active');
        getTools.classList.remove('notActive');
      });


      //on mouse leave
      card.addEventListener('mouseleave', () => {
        const getTools = card.querySelector('.ProjectTools');
        getTools.classList.remove('active');
        getTools.classList.add('notActive');
      });

      card.addEventListener('click', () => {
        let id = card.querySelector('#idProject').innerHTML;
        let idn = parseInt(id);
        console.log(idn);
        window.location.href = "<?= base_url() . 'show_projects/' ?>" + idn;
      });

    });
  });


  const addProjectButton =document.querySelector('#btn-add-projects');
    addProjectButton.addEventListener('click',()=>{
        window.location.href = "<?= base_url() . 'createProject' ?>";
    });



</script>
