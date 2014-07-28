Refaktor
========

### Installation ###

Installation des dépendances <code>npm install</code>

Compilation des fichiers JS vendor <code>gulp vendor</code>

Default task <code>gulp</code>

Data de test (console) <code>utils.createSampleData()</code>

### Bugs à régler ###
- [x] Animation à l'apparition des books et projets
- [x] Catégories de projet quand celle-ci n'existe pas
- [x] Catégories de cahier quand celle-ci n'existe pas
- [x] Editeur de projet quand l'id ne mène à rien
- [x] Editeur de cahiers quand l'id ne mène à rien
- [x] Editeur & prévisualiseur de cahiers quand l'id ne mène à rien
- [x] Comportement quand on supprime une catégorie avec des projets dedans --> on met tout dans la catégorie "all"
- [x] Comportement quand on supprime une catégorie avec des cahiers dedans --> on met tout dans la catégorie "all"
- [x] Comportement quand on supprime un projet qui est déjà dans un cahier --> on supprime toutes les instances qui sont dans les cahiers
- [x] Instant help qui se recharge sur chaque page
- [x] Texte "medias complémentaires" sur add project qui se décale parfois
- [x] Titre des pages quand on crée un projet ou un cahier
- [ ] Supprimer l'exportation quand on supprime un cahier exporté

### Bugs mineurs ###
- [ ] Faire venir les pages du haut quand on scrolle vers le haut sur la page bookeditor