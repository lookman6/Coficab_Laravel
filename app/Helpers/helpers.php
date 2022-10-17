<?php       
function getMainRoleName(){
  foreach(auth()->user()->role as $role){
        if($role == "respModule" || $role == "respFiliere")
            return $role->intitule;
        return $role->intitule;
  }
}