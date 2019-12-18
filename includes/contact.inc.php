<?php

if (isset($_POST['frmContact'])) {
  $nom = checkInput($_POST['nom']);
  $prenom = checkInput($_POST['prenom']);
  $mail = checkInput($_POST['mail']);
  $tel = checkInput($_POST['tel']);
  $message = checkInput($_POST['message']);

  $erreur = array();
  if ($nom === "")
    array_push($erreur, "Veuillez saisir votre nom");
  if ($prenom === "")
    array_push($erreur, "Veuillez saisir un prénom");
  if ($mail === "")
    array_push($erreur, "Veuillez saisir une adresse mail");
  if ($tel === "")
    array_push($erreur, "Veuillez saisir un numéro");
  if ($message === "")
    array_push($erreur, "Veuillez saisir un message");

  if (count($erreur) > 0) {
    $message = '<ul>';
    for($i = 0 ; $i < count($erreur) ; $i++) {
      $message .= '<li>';
      $message .= $erreur[$i];
      $message .= '</li>';
    }
    $message .= '</ul>';
    echo $message;
    require 'frmContact.php';
  }
  else {
    $sqlVerif = "SELECT COUNT(*) FROM site
    WHERE mail='" . $mail ."'";
    $nbrOccurences = $pdo->query($sqlVerif)->fetchColumn();
    if ($nbrOccurences > 0) {
      echo "Déjà chez Kris";
    }
else {
    $sql = "INSERT INTO site (nom, prenom, mail, tel, message) VALUES  ('" . $nom . "', '" . $prenom . "', '" . $mail ."', '" . $tel ."', '" . $message ."')";
    $query = $pdo->prepare($sql);
    $query->bindValue(':nom', $nom, PDO::PARAM_STR);
    $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $query->bindValue(':mail', $mail, PDO::PARAM_STR);
    $query->bindValue(':tel', $tel, PDO::PARAM_STR);
    $query->bindValue(':message', $message, PDO::PARAM_STR);

    $query->execute();
    echo "Kris te recontacteras";
    }
  }
}
else {
  $nom = $prenom = $mail = $tel = $message = "";
  require 'frmContact.php';
}
