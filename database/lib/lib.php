<?php
class GDPSLib {
    public function getIP(){ //From CvoltonGDPS
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ms = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ms = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ms = $_SERVER['REMOTE_ADDR'];
        }
        return $ms;
    }
    public function getDifficulty($diff){
        switch ($diff){
            case 0:
                $difficulty = "NA";
            break;
            case 10:
                $difficulty = "Easy";
            break;
            case 20:
                $difficulty = "Normal";
            break;
            case 30:
                $difficulty = "Hard";
            break;
            case 40:
                $difficulty = "Harder";
            break;
            case 50:
                $difficulty = "Insane";
            break;
            default:
                $difficulty = "Unknown";
            break;
        }
        return $difficulty;
    }
    public function getAudiotrack($audioid){
        switch ($audioid){
            case 0:
                $song = "Stereo Madness";
            break;
            case 1:
                $song = "Back on Track";
            break;
            case 2:
                $song = "Polargeist";
            break;
            case 3:
                $song = "Dry Out";
            break;
            case 4:
                $song = "Base After Base";
            break;
            case 5:
                $song = "Cant Let Go";
            break;
            case 6:
                $song = "Jumper";
            break;
        }
        return $song;
    }
    
    public function getLength($length){
        switch ($length) {
            case 0:
                $length = "Tiny";
            break;
            case 1:
                $length = "Short";
            break;
            case 2:
                $length = "Medium";
            break;
            case 3:
                $length = "Long";
            break;
        }
        return $length;
    }
}
?>