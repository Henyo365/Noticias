<?php
/**
 * A class that provides static methods for working with models.
 */
class Model {

    /**
     * Checks if a model file exists.
     *
     * @param string $modelname The name of the model to check.
     * @return bool True if the model file exists, false otherwise.
     */
    public static function exists($modelname){
        $fullpath = self::getFullpath($modelname);
        $found=false;
        if(file_exists($fullpath)){
            $found = true;
        }
        return $found;
    }

    /**
     * Returns the full path of a model file.
     *
     * @param string $modelname The name of the model.
     * @return string The full path of the model file.
     */
    public static function getFullpath($modelname){
        return "./admin/core/app/model/".$modelname.".php";
    }

    /**
     * Retrieves multiple records from a query result and maps them to model objects.
     *
     * @param object $query The query result.
     * @param string $aclass The name of the model class to map the records to.
     * @return array An array of model objects.
     */
    public static function many($query,$aclass){
        $cnt = 0;
        $array = array();
        while($r = $query->fetch_array()){
            $array[$cnt] = new $aclass;
            $cnt2=1;
            foreach ($r as $key => $v) {
                if($cnt2>0 && $cnt2%2==0){ 
                    $array[$cnt]->$key = $v;
                }
                $cnt2++;
            }
            $cnt++;
        }
        return $array;
    }

    /**
     * Retrieves a single record from a query result and maps it to a model object.
     *
     * @param object $query The query result.
     * @param string $aclass The name of the model class to map the record to.
     * @return object|null The model object or null if no record was found.
     */
    public static function one($query,$aclass){
        $cnt = 0;
        $found = null;
        $data = new $aclass;
        while($r = $query->fetch_array()){
            $cnt=1;
            foreach ($r as $key => $v) {
                if($cnt>0 && $cnt%2==0){ 
                    $data->$key = $v;
                }
                $cnt++;
            }

            $found = $data;
            break;
        }
        return $found;
    }

}

?>