<?php

class Logins {

    /**
     * For hashing a password into unreadable form.
     * @return string of hashed password
     */
    private static function hashPass($password){
        $passenc = "*";

        if (CRYPT_BLOWFISH == 1)
            $passenc = crypt($password, '$2a$07$afsnu3rnw9i3r80m93091dsa$');
        else
            fatal_error("Fatal error.");

        if($passenc === "*" || $passenc === "")
            fatal_error("Fatal error.");

        return $passenc;
    }

    /**
     * Attempt to login the user
     * @return boolean of if login is successful
     */
    public static function login($username, $password){
        // TODO: if already logged in, quit.
        if (Logins::isLoggedIn()) return true;

        $password_enc = Logins::hashPass($password);

        //echo $username . ' ' . $password . ' ' . $password_enc;

        $statement = DB::get()->prepare("SELECT * FROM `user` WHERE
            user_username = ? AND user_password = ?");
        $statement->bindValue(1, $username, PDO::PARAM_STR);
        $statement->bindValue(2, $password_enc, PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() === 1) {
            // correctly loggedin
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            Logins::doLogin($row);

            echo 'Logged in!';
            return true;
        } else {
            echo 'Not logged in!!'; // not loggedin
            return false;
        }
    }

    /**
     * Logout a user.
     */
    public static function logout(){
        if (!Logins::isLoggedIn()) return true;

        if(session_id() != '') {
            session_unset();
            session_destroy();
        }
        session_start();

        return true;
    }

    /**
     * Do the login and set the session.
     */
    private static function doLogin($row){
        session_unset();
        session_destroy();
        session_start();

        // store row
        $_SESSION['user'] = $row;
        $_SESSION['user_loggedin'] = true;

        $_SESSION['user_maxunits'] = $row['user_gender'] == 'female' ? 3 : 4;

        $stmt = DB::get()->prepare("SELECT session_id FROM session WHERE
            session_timefinish IS NULL AND session_user_id = ?");
        $stmt->bindValue(1, $_SESSION['user']['user_id'], PDO::FETCH_ASSOC);
        $stmt->execute();

        if ($stmt->rowCount() > 0){
            Logins::setCurrentSession($stmt->fetch(PDO::FETCH_ASSOC)['session_id']);
        }
    }

    /**
     * Register a new user
     */
    public static function register($info){
        if (Logins::isLoggedIn()) return false;

        $passwordenc = Logins::hashPass($info['password']);

        $stmt = DB::get()->prepare("INSERT INTO user (user_username, user_password, user_weight, user_gender)
				VALUES (?, ?, ?, ?)");
		$stmt->bindValue(1, $info['username'], PDO::PARAM_STR);
		$stmt->bindValue(2, $passwordenc, PDO::PARAM_STR);
		$stmt->bindValue(3, intval($info['weight']), PDO::PARAM_INT);
		$stmt->bindValue(4, $info['gender'], PDO::PARAM_STR);
		$stmt->execute();

        return Logins::login($info['username'], $info['password']);
    }

    /**
     * Checks if a user is logged in.
     */
    public static function isLoggedIn(){
        return isset($_SESSION['user']);
    }

    /**
     * Get the username.
     */
    public static function getCurrentUsername(){
        if (!Logins::isLoggedIn()) return false;
        return $_SESSION['user']['user_username'];
    }

    /**
     * Get the current userid.
     */
    public static function getCurrentUserID(){
        if (!Logins::isLoggedIn()) return false;
        return $_SESSION['user']['user_id'];
    }

    /**
     * Get the current user weight.
     */
    public static function getCurrentUserWeight(){
        if (!Logins::isLoggedIn()) return false;
        return floatval($_SESSION['user']['user_weight']);
    }

    /**
     * Get the current user gender.
     */
    public static function getCurrentUserGender(){
        if (!Logins::isLoggedIn()) return false;
        return $_SESSION['user']['user_gender'];
    }

    public static function newSession($hr, $min){


        $time = strtotime(date('Y-m-d')) + 24*60*60 + $hr*60*60 + $min*60;
        if ($hr == -1 || $min == -1) $time = NULL;


        $stmt = DB::get()->prepare("INSERT INTO session (session_user_id, session_soberby) VALUES (?, ?)");
        $stmt->bindValue(1, Logins::getCurrentUserID(), PDO::PARAM_INT);
        $stmt->bindValue(2, date('Y-m-d H:i:s', $time), PDO::PARAM_STR);
        $stmt->execute();

        $sessionid = DB::get()->lastInsertId();

        Logins::setCurrentSession($sessionid);
    }

    public static function setCurrentSession($newid){
        $_SESSION['sessionid'] = $newid;
    }

    public static function getCurrentSession(){
        if (!isset($_SESSION['sessionid'])) return NULL;
        return $_SESSION['sessionid'];
    }

    public static function endSession(){
        $test = DB::get()->prepare("SELECT * FROM sessiondrink WHERE sessdr_session_id = ?");
        $test->bindValue(1, Logins::getCurrentSession(), PDO::PARAM_INT);
        $test->execute();


        if ($test->rowCount() === 0) {
            $stmt = DB::get()->prepare("DELETE FROM session WHERE session_id = ?");
            $stmt->bindValue(1, Logins::getCurrentSession(), PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stats = Tools::calcStats(Logins::getCurrentSession());

            $stmt = DB::get()->prepare("UPDATE session SET session_timefinish = CURRENT_TIMESTAMP,
                session_calories = ?, session_unit = ? WHERE session_id = ?");
            $stmt->bindValue(1, $stats['calories'], PDO::PARAM_INT);
            $stmt->bindValue(2, $stats['units'], PDO::PARAM_INT);
            $stmt->bindValue(3, Logins::getCurrentSession(), PDO::PARAM_INT);
            $stmt->execute();
        }

        $_SESSION['sessionid'] = NULL;
    }

    public static function getMaxUnits(){
        return $_SESSION['user_maxunits'];
    }
}
