<?php
/**
	 * Parses albums from .json file and "echoes" content in formatted form.
	 * 
	 * @param int $id
	 * 
	 */
function data(int $id) {
    
    // Read the JSON file
    $json = file_get_contents(dirname(__FILE__) . '/../data/albums.json');
    
    // Decode the JSON file
    $json_data = json_decode($json,true);
    
    $album = $json_data[$id];
    // echo "<pre>";
    // var_dump($album);
    // echo "</pre>";

    
    if(is_null($album["artist"])){

        echo <<<"EOT"
        <div class="layer__picture">
            <div class="layers__album"><img src="$album[imgSrc]" alt="album"></div>
        </div>
        <div class="layer__header">
            <div class="layers__caption">Producer: $album[prod]</div>
            <div class="layers__title">Name: $album[name]</div>
            <div class="layers__audio"><audio src="$album[prodSrc]" controls=""></audio></div>
        </div>
        EOT;
    } else {

        $lyrics = null;
        if(is_null($album["lyrics"])){
            $lyrics = "";
        } else {
            $lyrics = <<<"EOT"
            <div class="layers__textin">
                <pre>$album[lyrics]</pre>
            </div>
            EOT;
        }

        echo <<<"EOT"
            <div class = "side-by-side">
                <div class = "album-content">
                    <div class="together">
                        <div class="layer__picture">
                            <div class="layers__album">
                                <img src="$album[imgSrc]" alt="album">
                            </div>
                        </div>
                        <div class="layer__header">
                            <div class="layers__caption">Producer: $album[prod]</div>
                            <div class="layers__title">Name: $album[name]</div>
                            <div class="layers__audio">
                                <audio src="$album[prodSrc]" controls=""></audio>
                            </div>
                        </div>
                    </div>
                    <div class="layers__reference">Product:</div>
                    <div class="together">
                        <div class="layer__picture">
                            <div class="layers__albRef">
                                <img src="$album[imgSrc]" alt="album">
                            </div>
                        </div>
                        <div class="layer__header">
                            <div class="layers__caption">Singer: $album[artist]</div>
                            <div class="layers__title">Name: $album[name]</div>
                            <div class="layers__audio">
                                <audio src="$album[soundSrc]" controls=""></audio>
                            </div>
                        </div>
                    </div>
                </div>
                $lyrics
            </div>
        EOT;
    }
    
}

/**
	 * Parses albums from .json file and returns decoded data.
     * 
     * @param int $page
     * 
     * @return mixed array of pagination data
	 */
function retrieve_data(int $page) {
    $json = file_get_contents(dirname(__FILE__) . '/../data/albums.json');
    $json_data = json_decode($json,true);
    $limit = 6;
    // $total_pages = ceil (len($json_data) / $limit);
    $offset = ($page - 1) * $limit;
    $result = array_slice($json_data, $offset, $limit);
    return $result;
}


/**
	 * Verifies if the user is eligible to log in.
	 * 
	 * @param string $email
     * @param string $password
	 * 
     * @return bool True if user is eligible to log in
	 */
function user(string $email, string $password){
    $json = file_get_contents(dirname(__FILE__) . '/../data/users.json');
    $json_data = json_decode($json,true);
    $our_user = null;
    foreach($json_data as &$user){
        if(strtolower($user["email"]) == strtolower($email)){
            $our_user = $user;
        }
    }

    if(is_null($our_user)) {
        return false;
    }

    if(!password_verify($password, $our_user["password"])) {
        return false;
    }
    $_SESSION["username"] = $our_user["username"];
    return true;
}

/**
	 * Registers user.
	 * 
	 * @param string $email
     * @param string $password
	 * 
     * @return bool True if user is successfully registered
	 */
function add_user(string $email, string $password, string $username) {
    $file_path = dirname(__FILE__) . '/../data/users.json';
    $json = file_get_contents($file_path);
    $json_data = json_decode($json,true);
    $our_user = null;
    foreach($json_data as &$user){
        if((strtolower($user["email"]) == strtolower($email)) || ($user["username"] == $username)){
            $our_user = $user;
        }
    }
    if(!is_null($our_user)) {
        return false;
    }

    $new_user = [
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'username' => $username,
    ];

    array_push($json_data, $new_user);

    $json_string = json_encode($json_data, JSON_PRETTY_PRINT);
    // Write in the file
    $fp = fopen($file_path, 'w');
    fwrite($fp, $json_string);
    fclose($fp);
    return true;
}

/**
	 * Toggles like for a specific album
	 * 
	 * @param string $username
     * @param int    $id
	 * 
     * @return bool True if the user successfully liked
	 */
function toggle_like(string $username, int $id) {
    // Read the JSON file
    $file_path = dirname(__FILE__) . '/../data/albums.json';
    $json = file_get_contents(dirname(__FILE__) . '/../data/albums.json');
    
    // Decode the JSON file
    $json_data = json_decode($json,true);
    
    if(is_null($json_data[$id]["likes"]) || empty($json_data[$id]["likes"])){
        $json_data[$id]["likes"] = array($username);
        $json_string = json_encode($json_data, JSON_PRETTY_PRINT);
        $fp = fopen($file_path, 'w');
        fwrite($fp, $json_string);
        fclose($fp);
        return true;
    } else if (!in_array($username, $json_data[$id]["likes"])) {
        // unset($messages[$key]);
        array_push($json_data[$id]["likes"], $username);
        $json_string = json_encode($json_data, JSON_PRETTY_PRINT);
        $fp = fopen($file_path, 'w');
        fwrite($fp, $json_string);
        fclose($fp);
        return true;
    } else {
        $json_data[$id]["likes"] = array_diff( $json_data[$id]["likes"], [$username] ); 
        $json_string = json_encode($json_data, JSON_PRETTY_PRINT);
        $fp = fopen($file_path, 'w');
        fwrite($fp, $json_string);
        fclose($fp);
        return true;
    }
    return false;
}

/**
	 * Checks if the album is liked
	 * 
	 * @param string $username
     * @param int    $id
	 * 
     * @return bool True if album is liked
	 */
function is_liked(string $username, int $id){
    $file_path = dirname(__FILE__) . '/../data/albums.json';
    $json = file_get_contents(dirname(__FILE__) . '/../data/albums.json');
    
    // Decode the JSON file
    $json_data = json_decode($json,true);
    
    if ((is_null($json_data[$id]["likes"]) || empty($json_data[$id]["likes"])) || (!in_array($username, $json_data[$id]["likes"]))) {
        return false;
    } 
    return true;
    
}

?>
