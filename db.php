<?php
    session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    // localhost version: $connection = mysqli_connect("127.0.0.1", "root", "root", "notesrank");
    $host = "summer-2021.cs.utexas.edu";
    $user = "cs329e_mitra_jau392";
    $pwd = "leo*bread4urban";
    $dbs = "cs329e_mitra_jau392";
    $port = "3306";


   $connection = mysqli_connect($host, $user, $pwd, $dbs);

    if($connection === false)
    {
        echo "Unable to establish database connection";
        exit;
    }
    if(isset($_SESSION["loggedin_user"]))
    {
        if(!is_numeric($_SESSION['loggedin_user']))
        {
            unset($_SESSION['loggedin_user']);
            session_regenerate_id(true);
        }
        else
        {
            $stmt = $connection->prepare("SELECT id,email from users where id = ?");
            $stmt->bind_param("i",$_SESSION['loggedin_user']);
            $stmt->execute();
            $res = $stmt->get_result();
            if($res->num_rows == 0)
            {
                logout();
            }
            else
            {
                $resRow = $res->fetch_array();
                $_SESSION["loggedin_email"] = $resRow["email"];
            }
        }
    }
    function processPosts(&$value)
    {
        $value = htmlspecialchars(strip_tags(trim($value)));
    }
    function attemptUserLogin($email,$password)
    {
        global $connection;
        $stmt = $connection->prepare("SELECT id,password from users where email = ?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows == 0)
            return false;
        else
        {
            $resRow = $res->fetch_array();
            if(password_verify($password,$resRow["password"]))
            {
                session_regenerate_id(true);
                $_SESSION["loggedin_user"] = $resRow["id"];
                header("location: dashboard.php");
                return true;
            }
            else
                return false;
        }
    }
    function registerUser($email,$passwordHash)
    {
        global $connection;
        $stmt = $connection->prepare("INSERT INTO users (email,password) VALUES (?,?)");
        $stmt->bind_param("ss",$email,$passwordHash);
        $stmt->execute();
        if($stmt->affected_rows == 0)
            return false;
        else
        {
            //$_SESSION["loggedin_user"] = $res->fetch_array()[0]["id"];
            //header("location: dashboard.php");
            return true;
        }
    }
    function isGuest()
    {
        return !isset($_SESSION['loggedin_user']);
    }
    function isLoggedIn()
    {
        return isset($_SESSION['loggedin_user']);
    }
    function guestOnlyPage()
    {
        if(isLoggedIn())
        {
            header("location: dashboard.php");
            exit;
        }
    }
    function userOnlyPage()
    {
        if(isGuest())
        {
            header("location: auth.php");
            exit;
        }
    }
    function logout()
    {
        $_SESSION['loggedin_user'] = null;
        unset($_SESSION['loggedin_user']);
        session_regenerate_id(true);
        header("location: auth.php");
        exit;
    }
    function loggedInUsername()
    {
        if(isLoggedIn())
        {
            if(isset($_COOKIE['username']))
                return $_COOKIE['username'];
            else {
                $email = loggedInEmail();
                $username = substr($email, 0, strpos($email, "@"));
                setcookie("username",$username);
                return $username;
            }
        }
        else
        {
            return "Guest";
        }
    }
    function loggedInEmail()
    {
        return $_SESSION["loggedin_email"];
    }
    function getMyPastUploads()
    {
        if(!isLoggedIn())
        {
            return [];
        }
        global $connection;
        $stmt = $connection->prepare("SELECT * FROM uploads WHERE user_id = ? ORDER BY id DESC");
        $stmt->bind_param("i",$_SESSION['loggedin_user']);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows > 0)
        {
            return $res->fetch_all(MYSQLI_ASSOC);
        }
        else
            return [];
    }
    function allNotesOrderByIdDesc()
    {
        if(!isLoggedIn())
        {
            return [];
        }
        global $connection;
        $stmt = $connection->prepare("SELECT * FROM uploads ORDER BY id DESC");
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows > 0)
        {
            return $res->fetch_all(MYSQLI_ASSOC);
        }
        else
            return [];
    }
    function getTop3Notes()
    {
        if(!isLoggedIn())
        {
            return [];
        }
        global $connection;
        $stmt = $connection->prepare("SELECT * FROM uploads ORDER BY average_rating DESC LIMIT 3");
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows > 0)
        {
            return $res->fetch_all(MYSQLI_ASSOC);
        }
        else
            return [];
    }
    function uploadNotes($title,$comments,$filename)
    {
        if(!isLoggedIn())
        {
            return false;
        }
        global $connection;
        $stmt = $connection->prepare("INSERT INTO uploads (user_id,title,file_name,author_comments) VALUES (?,?,?,?)");
        $stmt->bind_param("isss",$_SESSION['loggedin_user'],$title,$filename,$comments);
        $stmt->execute();
        return $stmt->affected_rows == 1;
    }
    function updateRating($notesId, $rating)
    {
        if(!isLoggedIn())
        {
            return false;
        }
        global $connection;
        $stmt = $connection->prepare("SELECT id from ratings where user_id = ? and upload_id = ?");
        $stmt->bind_param("ii",$_SESSION['loggedin_user'],$notesId);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows == 0)
        {
            $rate = $connection->prepare("INSERT INTO ratings (user_id,upload_id,rating) VALUES (?,?,?)");
            $rate->bind_param("iii",$_SESSION['loggedin_user'],$notesId,$rating);
            $rate->execute();
            if($rate->affected_rows == 0)
                return false;
            else
            {
                $calculateNewAverage = $connection->prepare("SELECT avg(rating) as avg_rating,count(id) as users from ratings where upload_id = ?");
                $calculateNewAverage->bind_param("i",$notesId);
                $calculateNewAverage->execute();
                $res = $calculateNewAverage->get_result();
                if($res->num_rows > 0)
                {
                    $updateAverages = $connection->prepare("UPDATE uploads set average_rating = ?, users_rated = ? where id = ?");
                    $avgs = $res->fetch_array();
                    $updateAverages->bind_param("ssi",round($avgs['avg_rating'],1),$avgs['users'],$notesId);
                    $updateAverages->execute();
                    return ($updateAverages->affected_rows != 0);
                }
            }
        }
        else
        {
            return false;
        }
    }
    function getMaximumFileUploadSize()
    {
        return min(convertPHPSizeToBytes(ini_get('post_max_size')), convertPHPSizeToBytes(ini_get('upload_max_filesize'))) / 1024 / 1024;
    }
    function convertPHPSizeToBytes($sSize)
    {
        $sSuffix = strtoupper(substr($sSize, -1));
        if (!in_array($sSuffix,array('P','T','G','M','K'))){
            return (int)$sSize;
        }
        $iValue = substr($sSize, 0, -1);
        switch ($sSuffix) {
            case 'P':
                $iValue *= 1024;
            case 'T':
                $iValue *= 1024;
            case 'G':
                $iValue *= 1024;
            case 'M':
                $iValue *= 1024;
            case 'K':
                $iValue *= 1024;
                break;
        }
        return (int)$iValue;
    }
    function ratingView($rating)
    {
        $ratedStar = '<span class="fa fa-star" style="color:orange"></span>';
        $halfratedStar = '<span class="fa fa-star-half-o" style="color:orange"></span>';
        $unratedStar = '<span class="fa fa-star-o" style="color:#444444"></span>';
        $outstr = "";
        for($i=0;$i<floor($rating);$i++)
            $outstr.=$ratedStar;


        if(strpos($rating,".") !== false)
        {
            $outstr.=$halfratedStar;
            $rating = floor($rating)+1;
        }


        for($i=0;$i<(10-$rating);$i++)
            $outstr.=$unratedStar;

        return $outstr;
    }
    function uploadEmbedHelper($upload,$height=500)
    {
        //return $upload['file_name'];
        return '<div class="card">
                    <div class="card-header">Title: '.$upload['title'].'</div>
                    <div class="card-body">
                        <p>'.$upload['author_comments'].':</p>
                        <p>Rating: '.ratingView($upload['average_rating']).' <small class="text-muted">('.$upload['average_rating'].' / '.$upload['users_rated'].' ratings)</small></p>
                    </div>
                    <embed src="'.$upload['file_name'].'" class="card-img-bottom" type="application/pdf" width="100%" height="'.$height.'px">
                </div>';
    }
?>
