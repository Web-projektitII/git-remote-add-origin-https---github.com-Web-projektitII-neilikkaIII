<!DOCTYPE html>
<html lang="fi">
<?php
$title = "Rekisteröityminen";
$result = false;
$virheet = [];
include('tietokantarutiinit.php');
include('header.php');

function nayta($kentta){
    echo (!isset($GLOBALS['virheet'][$kentta]) and isset($_POST[$kentta])) ? $_POST[$kentta] : ""; 
    return;
    }
    
    function is_invalid($kentta){
      echo isset($GLOBALS['virheet'][$kentta]) ? "is-invalid" : ""; 
      return;
      }
    
    function is_invalid_variable($kentta){
       $is_invalid = isset($GLOBALS['virheet'][$kentta]) ? "is-invalid" : ""; 
       return $is_invalid;
       }  
    
       if (isset($_POST['painike'])){
           $kentat = ['firstname','lastname','email','mobilenumber','password'];
           $pakolliset = ['firstname','lastname','email','mobilenumber','password'];
           
        foreach ($kentat as $kentta) {
              $$kentta = $_POST[$kentta] ?? '';
              if (!is_array($$kentta)){
                 $$kentta = $yhteys->real_escape_string(strip_tags(trim($$kentta)));
                 }
              else {
                 foreach ($$kentta as $key => $value) {
                    $$kentta[$key] = $yhteys->real_escape_string(strip_tags(trim($value)));
                    }
                 $$kentta = implode(",",$$kentta);  
                }
              if (!$$kentta && in_array($kentta,$pakolliset)) $virheet[$kentta] = true;
              }
          
           $created = date("Y-m-d H:i:s",time());
           $kentat[] = $created;    
           $str_kentat = implode(", ",$kentat);
           //echo "str_kentat:$str_kentat<br>";
           
           if (!$virheet) {
              $query = "INSERT INTO users ($str_kentat) VALUES ('$firstname','$lastname','$email','$mobilenumber','$password','$created')";
              //echo "$query<br>";
              //exit;
              $result = $yhteys->query($query);
              $lisattiin = $yhteys->affected_rows;
           }
            
          }
?>
<div class="container">
<h1>REKISTERÖITYMINEN</h1> 

<form method="post" novalidate class="needs-validation">
<fieldset>
<legend>Rekisteröityminen</legend>   

<div class="row mb-sm-1">
<label class="form-label mb-0 col-sm-4">Etunimi</label>
<div class="col-sm-8">
<input id="firstname" name="firstname" class="form-control <?php is_invalid('firstname');?>" placeholder="Etunimi" value="<?php nayta('firstname');?>" autofocus required></input>
<div class="invalid-feedback">Etunimi puuttuu.</div>
</div></div>

<div class="row mb-sm-1">
<label class="form-label mb-0 col-sm-4">Sukunimi</label>
<div class="col-sm-8">
<input id="lastname" name="lastname" class="form-control <?php is_invalid('lastname');?>" placeholder="Sukunimi" value="<?php nayta('lastname');?>" required></input>
<div class="invalid-feedback">Sukunimi puuttuu.</div>
</div></div>

<div class="row mb-sm-1">
<label class="form-label mb-0 col-sm-4">Sähköpostiosoite</label>
<div class="col-sm-8">
<input id="email" name="email" type="email" class="form-control <?php is_invalid('email');?>" placeholder="etunimi.sukunimi@yritys.fi" value="<?php nayta('email');?>" required></input>
<div class="invalid-feedback">Sähköpostiosoite puuttuu.</div>
</div></div>

<div class="row mb-sm-1">
<label class="form-label mb-0 col-sm-4">Matkapuhelinnumero</label>
<div class="col-sm-8">
<input id="mobilenumber" name="mobilenumber" class="form-control <?php is_invalid('mobilenumber');?>" placeholder="358XX12345678" value="<?php nayta('mobilenumber');?>" required></input>
<div class="invalid-feedback">Matkapuhelinnumero puuttuu.</div>
</div></div>

<div class="row mb-sm-1">
<label class="form-label mb-0 col-sm-4">Salasana</label>
<div class="col-sm-8">
<input id="password" name="password" type="password" class="form-control <?php is_invalid('password');?>" placeholder="salasana" required></input>
<div class="invalid-feedback">Salasana puuttuu.</div>
</div></div>

<div class="row mb-sm-1">
<label class="form-label mb-0 col-sm-4 nowrap">Salasana uudestaan</label>
<div class="col-sm-8">
<input id="password2" name="password2" type="password" class="form-control <?php is_invalid('password2');?>" placeholder="salasana uudestaan" required></input>
<div class="invalid-feedback">Salasana puuttuu.</div>
</div></div>

<input type="submit" name="painike" class="btn btn-primary" value="Tallenna">  
</fieldset>
</form>


</div>
<?php
include('footer.html')
?>
</html>