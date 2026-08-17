![logo](assets/logo.svg)

# Alibi Genie (Alibi.com)

Ce projet est né d'une petite aventure technique dans le cadre d'un travail pratique de programmation web en PHP. L'idée de départ était simple : repousser mes compétences en développement web backend et frontend à travers une application complète et dynamique, tout en créant un outil décalé pour générer des excuses improbables et piéger mes amis.

Au fil de la conception, j'ai voulu faire d'Alibi.com un véritable générateur d'alibis interactif capable d'adapter ses scénarios selon le niveau de gravité ou de crédibilité souhaité, avec la possibilité de fabriquer de fausses preuves justificatives. Côté données, j'ai fait le choix d'une architecture légère et directe, sans base de données lourde : la persistance repose sur un simple fichier JSON côté serveur couplé au localStorage du navigateur(pas encore implémenté lol) pour gérer l'historique et le classement.

## Lancement du projet

Pour tester l'application en local avec le serveur PHP intégré, il suffit d'exécuter la commande suivante à la racine du dossier :

```bash
php -S localhost:8000
```

Il ne reste plus qu'à ouvrir `http://localhost:8000` dans votre navigateur pour commencer à générer vos premières esquives.

Si le projet vous plaît et que vous avez envie d'ajouter de nouvelles idées de scénarios, d'améliorer le code ou d'imaginer des fonctionnalités encore plus folles, n'hésitez pas à contribuer, ça serait vraiment chouette de continuer l'aventure et de se marrer ensemble ! 😉
