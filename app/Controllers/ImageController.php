<?php
namespace App\Controllers;



class ImageController extends BaseController{
    public $images;
    public function __construct(){
        $images_json_path = 'Designes.json';
        $images_json = file_get_contents($images_json_path);
        $images = json_decode($images_json, true);
        $this->images = $images['images'];
    }
    public function showImages(){
        //public/images.json
      


        return view('include/inc_header').view('show_images', ['images' => $this->images]);
    }

    public function showImage($idImage){
        //public/images.json
        echo $idImage;

        foreach($this->images as $image){
            if($image['id'] == $idImage){
                return view('include/inc_header').view('show_images', ['images' => $this->images]). view('show_image', ['image' => $image]);
            }
        }
     
       // return view('include/inc_header').view('show_images', ['images' => $this->images]). view('show_image', ['image' => $image]);
    }
    private function checkIfImage($file){
        $imageFileType = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
        $check = getimagesize($file["tmp_name"]);
        if($check !== false) {
            return true;
        } else {
            return false;
        }
    }
    private function getMaxId(){
        $maxId = 0;
       
        foreach($this->images as $image){
            if($image['id'] > $maxId){
                
                $maxId = $image['id'];
            }
        }
        return $maxId;
    }
     function updateJson(){
        $images_json_path = 'Designes.json';
        $images_json = file_get_contents($images_json_path);
        $images = json_decode($images_json, true);
        $images['images'] = $this->images;
        $images_json = json_encode($images);
        file_put_contents($images_json_path, $images_json);
    }
    public function createImage(){
        
        if(isset($_FILES['image']) && $_FILES['image']['size'] > 0)
        {
            $file = $_FILES['image'];
            if($this->checkIfImage($file)){

                $target_dir = "images/";
                $target_file = $target_dir . basename($file["name"]);
                move_uploaded_file($file["tmp_name"], $target_file);
                
                $imageUrl = base_url()."/".$target_file;
    
                $imageName = $file["name"];
                //remove the extension
                $imageName = substr($imageName, 0, strpos($imageName, "."));
    
                $imageId = $this->getMaxId() + 1;
    
                
    
            }
        }
        else if( isset($_POST['url']))
        {
            $imageUrl = $_POST['url'];
            //get the last part of the url
            $imageName = substr($imageUrl, strrpos($imageUrl, '/') + 1);
            //remove the extension
            $imageName = substr($imageName, 0, strpos($imageName, "."));

            $imageId = $this->getMaxId() + 1;
        }
        else{
            echo "not an image";
        }

        return view('include/inc_header').view('createImage', 
                ['imageUrl' => $imageUrl,
                'imageName'=> $imageName,
                'imageId' => $imageId]);
    }


    public function modifyImage(){
        echo "test";
        $id = $_POST['id'];
        $name = $_POST['name'];
        $url = $_POST['url'];

        foreach($this->images as $key => $image){
            if($image['id'] == $id){
                $this->images[$key]['name'] = $name;
                $this->images[$key]['url'] = $url;
                $this->updateJson();
                echo "success";
                return;
             
            }
        }


        //if not found create new image
        array_push($this->images,[
            'id' => $id,
            'name' => $name,
            'url' => $url
        ]);
        $this->updateJson();
        echo "success";
        //return view('include/inc_header').view('show_images', ['images' => $this->images]);


    }

    public function consultImage($idImage){
        
        foreach($this->images as $image){
            if($image['id'] == $idImage){
                $imageUrl = $image['url'];
                $imageName = $image['name'];
                $imageId = $image['id'];
            }
        }

        return view('include/inc_header').view('createImage', 
        ['imageUrl' => $imageUrl,
        'imageName'=> $imageName,
        'imageId' => $imageId]);

    }

    public function deleteImage($id){
        foreach($this->images as $key => $image){
            if($image['id'] == $id){
                unset($this->images[$key]);
                $this->updateJson();
                //redirect to show images
                return redirect()->to(base_url()."/show_images" );
            }
        }
        return redirect()->to(base_url()."/show_images" );
    }
}