####PENSE BETE DES TRUCS A FAIRE :

1. General :
* Revoir le bouton a coté du champs "inscris ton assos'" sur la page d'accueil.
* Trouver une veritable "Petite phrase d'accroche trop styléééééé"
* Gros probleme avec les error 404 qui ne s'affichent plus depuis la mise en place des Flash
  message. Certainement a voir avec Antoine le 2 janvier, car Simon et Thibault n'ont eux meme
  pas trouvé de solution

2. Tatain :
* Mettre en forme le mail d'invitation (header et body du mail)
 => $mail->Body dans AssociationAdminController
* condition pour verifier que le input hide contenant le token d'asso dans le formulaire
  d'inscription contient un token qui existe (pour eviter que des bots fassent
  n'importe quoi ...)

3. Bud :

4. Oshiiro :

5. JL :
* layout->association = liste des membres + mes derniere transac ( utilisateur et admin )
* layout->back = toutes les transac des membres
* layout_back->gestion_association = liste des membres ( supprimer, ajouter argent, inviter membre) ( admin uniquement )
