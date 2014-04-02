# language: fr
Fonctionnalité: S'authentifier dans l'interface d'administration
    Afin de gérer les contenus dans l'interface d'administration
    En tant que rédacteur
    Je dois être capable de m'identifier en utilisant de bons identifiants
    Et être sûr que personne ne peut accéder à l'interface d'administration sans un accès valide

    Scénario: Accéder à l'interface de connexion
        Etant donné que je suis à "/"
        Quand je vais à "/admin/login"
        Alors je dois voir "Login"