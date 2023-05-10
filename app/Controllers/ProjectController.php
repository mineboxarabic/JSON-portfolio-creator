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
            'image' => $file,
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
    function getMaxId(){
        $maxId = 0;
       
        foreach($this->Projects as $Project){
            if($Project['id'] > $maxId){
                
                $maxId = $Project['id'];
            }
        }
        return $maxId;
    }
    public function deleteProject($id){
        $newProjects = [];
        foreach($this->Projects as $Project){
            if($Project['id'] != $id){
                array_push($newProjects, $Project);
            }
        }
        $this->Projects = $newProjects;
        $this->updateJSON();
        return redirect()->to(base_url().'show_Projects');
    }

    


}




