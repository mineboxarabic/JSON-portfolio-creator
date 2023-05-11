<?php
namespace App\Controllers;


class ProjectController extends BaseController{
    public $Projects;

    public function __construct(){
        $Projects_json_path = 'Projects.json';
       
        $Projects_json = file_get_contents($Projects_json_path);
        $Projects = json_decode($Projects_json, true);
        $this->Projects = $Projects['projects'];
  
    }
    public function showProjects(){
        //public/Projects.json
        return view('include/inc_header').view('show_Projects', ['Projects' => $this->Projects]);
    }
    
    public function createProject(){

        return view('include/inc_header').view('createProject');
     }

     public function addProject()
    {


        /*
         "id":
            "Name":"ArlesX Agenda",
            "Description":{
                "en": 
                "fr":
            },
            "mdFile":
            "Image":
            "github":
            "keyWords"
         */


        //projectKeywords projectDiscFR projectDiscEN file projectName projectUrl 
        $name = $this->request->getPost('projectName');
        $descriptionEN = $this->request->getPost('projectDiscEN');
        $descriptionFR = $this->request->getPost('projectDiscFR');
        $file = $_FILES['file'];
        $url = $this->request->getPost('projectUrl');
       $keyword = $_POST['projectKeywords'];
        $keywords = explode(',', $keyword);

        $id = $this->getMaxId() + 1;
        $newProject = [
            'id' => $id,
            'Name' => $name,
            'description' => [
                'en' => $descriptionEN,
                'fr' => $descriptionFR
            ],
            'mdFile' => 'undefined',
            'github' => $url,
            'keyWords' => $keywords
        ];

        if($this->checkIfImage($file)){
            $newProject['Image'] = base_url() .'Assets/images/'. $file['name'];
            //check if Assets/images exists
            if(!file_exists('Assets/images')){
                mkdir('Assets/images');
            }
            //move file to Assets/images
            move_uploaded_file($file['tmp_name'], 'Assets/images/'.$file['name']);
            echo 'here';

        }else{
            echo 'not an image';
            return;
        }


        array_push($this->Projects, $newProject);
        $this->updateJSON();
        return redirect()->to(base_url().'show_Projects');

    }



    function updateJSON(){
        $Projects_json_path = 'Projects.json';
        $Projects_json = file_get_contents($Projects_json_path);
        $Projects = json_decode($Projects_json, true);
        $Projects['projects'] = $this->Projects;
        $Projects_json = json_encode($Projects);
        file_put_contents($Projects_json_path, $Projects_json);
    }

    function checkIfImage($file){
        $imageFileType = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
        $check = getimagesize($file["tmp_name"]);
        if($check !== false) {
            return true;
        } else {
            return false;
        }
    }
    function checkIfImageUrl($url){
        $imageFileType = strtolower(pathinfo($url,PATHINFO_EXTENSION));
        $check = getimagesize($url);
        if($check !== false) {
            return true;
        } else {
            return false;
        }
    }
    function getMaxId(){
        $maxId = 0;
       
        foreach($this->Projects as $Project){
            if($Project['id'] > $maxId){
                
                $maxId = $Project['id'];
            }
        }
        return $maxId;
    }

    function deleteProject($id){
        $index = 0;
        foreach($this->Projects as $Project){
            if($Project['id'] == $id){
                unset($this->Projects[$index]);
                $this->updateJSON();
                return redirect()->to(base_url().'show_Projects');
            }
            $index++;
        }
    }

    function modifyProject(){
 
        $name = $this->request->getPost('projectName');
        $descriptionEN = $this->request->getPost('projectDiscEN');
        $descriptionFR = $this->request->getPost('projectDiscFR');


        if($_FILES['file']['name'] != "")
            $file = $_FILES['file'];



        $imageUrl = $this->request->getPost('url');
        $url = $this->request->getPost('projectUrl');
       $keyword = $_POST['projectKeywords'];
        $keywords = explode(',', $keyword);
        $id = $this->request->getPost('id');

        $index = 0;

        foreach($this->Projects as $Project){
            if($Project['id'] == $id){

                $this->Projects[$index]['Name'] = $name;
                $this->Projects[$index]['description']['en'] = $descriptionEN;
                $this->Projects[$index]['description']['fr'] = $descriptionFR;
                $this->Projects[$index]['github'] = $url;
                $this->Projects[$index]['keyWords'] = $keywords;

                echo "test";
                
                if($_FILES['file']['name'] != "" && $this->checkIfImage($file)){
                    
                    $this->Projects[$index]['Image'] = base_url() .'images/'. $file['name'];
                    //check if images exists
                    if(!file_exists('images')){
                        mkdir('images');
                    }
                    //move file to images
                    move_uploaded_file($file['tmp_name'], 'images/'.$file['name']);

                }
                else{
                  

                    if(isset($imageUrl)){
                    
                        $this->Projects[$index]['Image'] = $imageUrl;
                    }
                    else{
                        echo 'URL not an image';
                        return;
                    }
                    
                }
                
                $this->updateJSON();
                return redirect()->to(base_url().'show_Projects');
            }
            $index++;
        }


    }

    public function consultProject($id){
        $index = 0;
        foreach($this->Projects as $Project){
            if($Project['id'] == $id){
                return view('include/inc_header').view('consultProject', ['Project' => $Project]);
            }
            $index++;
        }
    }

    function getProject($id){
        $index = 0;
        foreach($this->Projects as $Project){
            if($Project['id'] == $id){
                return $Project;
            }
            $index++;
        }
    }
    public function show_Project($id){
        $project= $this->getProject($id);
        header('Location: test.php');
        echo 'location: '.'http://'.$project['github'];
       
    }
}




