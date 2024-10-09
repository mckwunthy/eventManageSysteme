################# App Web de gestion d'évènements ###################

Description : application web de gestion d'évènement
			écris en PHP, MySql, Doctrine, Jquery

- créez un compte et connectez vous pour continuer !

- onglet "Home" : liste des évènements

- onglet "create event" : remplissez le formulaire de création d'évènement
					nb: le champ "imgUrl" : entrez le lien vers l'image que vous 
						souhaitez utiliser en illustration

- onglet "Participate" : la liste des évènement auxquels vous participez
					Pour participer à un évènement, dans l'onglet "Home",
					cliquez sur "Take part"
					le button "More..." permet de visualiser les détails de l'évènement



-onglet "Log out" : se deconecter


NB : 
1- creez une base de donnee mysql: eventsms
2- creer le schema : cmd-> php bin/console orm:schema-tool:create
3- utiliser des fake data: cmd -> php dump_data.php

nb: le password des comptes : azerty123


Pour aller plus rapidement :
	creez la base de donnee mysql (eventsms)
	puis lancer la commande (dans ms visual code) :  php bin/loader
	





Bon usage ;-)

@McKwunthy