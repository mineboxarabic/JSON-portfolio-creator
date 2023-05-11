<style>
    img{
        width: 300px;
        height: 300px;
        object-fit: cover;
        cursor: pointer;
    }

    .keyword {
			display: inline-block;
			padding: 5px;
			margin-right: 10px;
			background-color: #f0f0f0;
			border-radius: 5px;
		}
		.remove-btn {
			padding: 5px;
			background-color: #ff0000;
			color: #fff;
			border: none;
			border-radius: 5px;
			cursor: pointer;
		}
</style>

<div class="container"> 

<!-- Project image -->
    <form action="<?= base_url() . 'modifyProject'?>" method="POST" enctype="multipart/form-data" >
    <input type="file" name="file" id="imageFile" hidden>
    <input value="<?= $Project['Image'] ?>" type="text" name="url" id="imageFile" hidden>
        <img src="<?= $Project['Image'] ?>" id="image-upload" class="rounded mx-auto d-block" src="project.png" alt="...">
    <h1><?= $Project['Name'] ?></h1>
<!-- End project image -->

<!-- Project Id -->
<input  type="text" value="<?= $Project['id'] ?>" name="id" id="idProject" hidden required>
<!-- End project Id -->

<!-- Project name -->
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Image name</span>
        </div>
        <input value="<?= $Project['Name'] ?>" name="projectName" required placeholder="Type a name for you project" type="text" id="imagename" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" >
    </div>
<!-- End of project name -->


<!-- Project URL -->
    <div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon3">URL</span>
    </div>
    <input value="<?= $Project['github'] ?>" name="projectUrl"  type="text" required class="form-control" id="Projecturl" aria-describedby="basic-addon3">
    </div>
<!-- End of project URL -->


<!-- Project description EN -->
    <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Description EN:</label>
    <textarea  name="projectDiscEN" required class="form-control" id="exampleFormControlTextarea1" rows="3"><?= $Project['description']['en'] ?></textarea>
    </div>
<!-- End of project description -->


<!-- Project description FR -->
    <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Description FR:</label>
    <textarea name="projectDiscFR" required class="form-control" id="exampleFormControlTextarea1" rows="3"><?= $Project['description']['fr'] ?></textarea>
    </div>
<!-- End of project description -->


<!-- Project keywords -->
    <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Keywords:</label>
    <textarea name="projectKeywords" required hidden class="form-control" id="keywordTextArea" rows="3"></textarea>
    </div>
    <div class="keyword-container" >
        <h1>Keyword Selector</h1>
        <input type="text" id="keyword-input">
        <button type="button" onclick="addKeyword()">Add Keyword</button>
        <div id="keyword-list"></div>
    </div>
<!-- End of project keywords -->



<button type="submit" class="saveButton btn btn-primary">
    <i class="fas fa-save"></i>
    Save
</button>
</form>
</div>


<script defer type="module">

let imageUpload = document.querySelector("#image-upload");
let imageFile = document.querySelector("#imageFile"); 
imageUpload.addEventListener("click", function(){
	imageFile.click();

})

imageFile.addEventListener("change", function(){
	let file = this.files[0];
	if(file){
		let reader = new FileReader();
		reader.onload = function(){
			imageUpload.setAttribute("src", this.result);
		}
		reader.readAsDataURL(file);
	}
})


const saveButton = document.querySelector(".saveButton");
saveButton.addEventListener("click", function(){
    
})

</script>

<script>
		var keywords = [];

		function addKeyword() {
			var keywordInput = document.getElementById("keyword-input");
			var keywordList = document.getElementById("keyword-list");
			var keyword = keywordInput.value.trim();
            let keywordTextArea = document.getElementById("keywordTextArea");
			if (keyword !== "" && !keywords.includes(keyword)) {
				keywords.push(keyword);

				var keywordElem = document.createElement("span");
				keywordElem.className = "keyword";
				keywordElem.textContent = keyword;

				var removeBtn = document.createElement("button");
				removeBtn.className = "remove-btn";
				removeBtn.textContent = "X";
				removeBtn.onclick = function() {
					removeKeyword(keyword);
				}

				keywordElem.appendChild(removeBtn);
				keywordList.appendChild(keywordElem);
                keywordTextArea.value = keywords;
				keywordInput.value = "";

			}
		}

		function removeKeyword(keyword) {
			var keywordList = document.getElementById("keyword-list");
			keywords = keywords.filter(function(kw) {
				return kw !== keyword;
			});
			keywordList.innerHTML = "";
			keywords.forEach(function(kw) {
				var keywordElem = document.createElement("span");
				keywordElem.className = "keyword";
				keywordElem.textContent = kw;

				var removeBtn = document.createElement("button");
				removeBtn.className = "remove-btn";
				removeBtn.textContent = "X";
				removeBtn.onclick = function() {
					removeKeyword(kw);
				}

				keywordElem.appendChild(removeBtn);
				keywordList.appendChild(keywordElem);
			});
		}
        //on click , addKeyword()
        document.getElementById("keyword-input").addEventListener("keyup", function(e){
            if( e.keyCode=== 188){
                addKeyword();
            }
        });

        document.addEventListener("DOMContentLoaded", function(){
            let KeyWords = <?= json_encode($Project['keyWords']) ?>;
            let keywordTextArea = document.getElementById("keywordTextArea");
            let keywordList = document.getElementById("keyword-list");
            let keywordInput = document.getElementById("keyword-input");
            KeyWords.forEach(function(kw) {
                keywordInput.value = kw;
                addKeyword();
            });
        })
                
	</script>