<?php
/**
 * undocumented class
 *
 * @package default
 * @author  
 */
class AdminPage extends Page {
    
    const Brothers = -5;
    
    public function __construct($title,Member $user,$officers)
    {
        parent::__construct($title);
        $officers[] = 'web';
        $this->authenticate($user, $officers);
    }
    public function authenticate(Member $user,$officers){
        if (in_array(self::Brothers, $officers) && $user->type >= Person::BROTHER){
            return true;
        }
        
        $newOfficers;
        foreach ($officers as $officer) {
            $newOfficers[] = is_int($officer) ? Officer::getOfficer($officer) : Officer::getOfficerByName($officer);
        }
        
        $userOfficers = Officer::getOfficersByUser($user);
        $compare = function($a1,$a2){
            return ($a1 === $a2) ? 0 : -1;
        };
        $intersection = array_uintersect($newOfficers, $userOfficers, $compare);
        
        if (count($intersection)>0) {
            return true;
        } else {
            throw new Exception("Admin Page: Permision Denied", 1);
        }
    }
    
} // END
?>