<?php

  /**@param $dir string Searching start path
    *@param  $file string Folder name or File name with extension
    *@param  $root Internal work variable 
    *@return string Searched file or folder complete path  */
  function searcher(string $dir, string $file, ?array $root = null): string|bool{
    if (strpos($dir, DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR) != false){
      $dir = str_replace(DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $dir);
    }
    if(substr($dir, -1) != DIRECTORY_SEPARATOR){
      $dir = $dir.DIRECTORY_SEPARATOR;
    }
    $search = $dir.$file;
    if (!isset($root)){
      $root = glob($dir.'*');
    } 
    if (in_array($search, $root) and file_exists($search)){
      return $search;
    } 
    foreach ($root as $path){
      //echo 'passando for each <br><br>';
      if (is_dir($path)){
        // var_dump($root);echo '<br><br>';
        //var_dump($path);echo '<br><br>';
        $pathExpandaded = glob($path.DIRECTORY_SEPARATOR.'*');
        //ar_dump($pathExpandaded);echo '<br><br>';
        if (in_array($path.DIRECTORY_SEPARATOR.$file, $pathExpandaded)){
          return $path.DIRECTORY_SEPARATOR.$file;
        }
        foreach($pathExpandaded as $in){

          if (is_dir($in) and !in_array($in, $root)){
            array_push($root, $in);
            return searcher ($dir, $file, $root);
          }
        }
      }
    }
    return false;
    }

    // ------------- TESTE COM RECURSIVE DIRECTORY INTERATOR - não funcioanl------------------------------//
    // function rsearcher($dir, $file){
    //   if (strpos($dir, DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR) != false){
    //     $dir = str_replace(DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $dir);
    //   }
    //   if(substr($dir, -1) != DIRECTORY_SEPARATOR){
    //     $dir = $dir.DIRECTORY_SEPARATOR;
    //   }
    //   $listar = new RecursiveDirectoryIterator($dir);
    //   $recursivo = new RecursiveIteratorIterator($listar);

    //   foreach($recursivo as $obj){
    //     if (!isset($array)){
    //       $array = [];    }
    //     array_push ($array, $obj->getPathname());
    //   }
    //   if (in_array($file, $array)){
    //     $key = array_search("$file", $array);
    //     return $key;
    //   }      
    // }

  
  //---------------- PRIMEIRA VERSÃO ---------------------------------//
  // function searchFile($dir, $file): string|bool{
  //   $search = $dir.$file;
  //   //Verifica se o arquivo existe no diretório
  //   if((!is_dir($search)) and (file_exists($search))){
  //     return $search;
  //   }        
  //   $scan = scandir($dir);
  //   //Percorre todos os arquivos e diretórios
  //   foreach($scan as $path){
  //     if($path != '.' and $path != '..'){
  //       $newDir = $dir.$path.DIRECTORY_SEPARATOR;
  //         if(is_dir($newDir)){//Verifica se é diretório
  //           return searchFile($newDir, $file);
  //         }

  //       }
  //   }//Fecha Foreach
    
  //   return false;//Retorna falso caso não encontre   
  // } //Fecha function