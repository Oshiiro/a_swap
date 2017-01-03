####PENSE BETE DES TRUCS A FAIRE :

1. General :
* Revoir le bouton a coté du champs "inscris ton assos'" sur la page d'accueil.
* Trouver une veritable "Petite phrase d'accroche trop styléééééé"

2. Tatain :
* Mettre en forme le mail d'invitation (header et body du mail)
 => $mail->Body dans AssociationAdminController
* condition pour verifier que le input hide contenant le token d'asso dans le formulaire
  d'inscription contient un token qui existe (pour eviter que des bots fassent
  n'importe quoi ...)
* Message de confirmation "etes vous sure de vouloir renvoyer cet utilisateur de votre asso ?"
      tu met sur un lien un event click qui fait un confirm. Si confirm == fasle (donc annulation) tu fais un preventDefault qui annulera la redirection de ton lien
      la location tu y touche pas.Tu met ton lien comme d'habitude
      js va juste bloquer la redirection si besoin sinon il laissera faire la redirection du lien comme dab
  A VOIR LE 2 JANVIER AVEC GEELIK !!!
________
DIFFICULTE RENCONTRéES (soutenance) :
* Pbm de securité dans le systeme d'invitation ; obligé de refaire une journée de travail et de creer
une nouvelle table "invitation" dans la BDD.

3. Bud :

4. Oshiiro :

5. JL :
* layout->association = liste des membres + mes derniere transac ( utilisateur et admin )
* layout->back = toutes les transac des membres
* layout_back->gestion_association = liste des membres ( supprimer, ajouter argent, inviter membre) ( admin uniquement )

6. Bugs reperés :

* Plein de route, non securisées par des allowTo ou autres verifs de role. Il faudra TOUTES les checker !
