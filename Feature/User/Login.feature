Fonctionnalité: S'authentifier sur le site
    En tant qu'utilisateur 
    Je veux pouvoir m'authentifier sur le site me permettant ainsi d'accéder à de nouvelles fonctionnalités

    Scénario: L'identifiant n'est pas renseigné
    Étant donné que l'identifiant n'est pas renseigné
    Et que je ne suis pas authentifié
    Quand je lance l'authentification
    Alors j'ai un message d'erreur m'indiquant que la saisie de l'identifiant est obligatoire

    Scénario: Le mot de passe n'est pas renseigné
    Étant donné que le mot de passe n'est pas renseigné
    Et que je ne suis pas authentifié
    Quand je lance l'authentification
    Alors j'ai un message d'erreur m'indiquant que la saisie du mot de passe est obligatoire

    Scénario: L'identifiant n'existe pas
    Étant donné qu'il existe des utilisateurs avec les identifiants suivants :
    | Identifiant |
    | Aslak       |
    | Julien      |
    | Matt        |
    Et que j'ai saisi l'identifiant "Adrien"
    Et que j'ai saisi le mot de passe "P4ssw0rd"
    Et que je ne suis pas authentifié
    Quand je lance l'authentification
    Alors j'ai le message d'erreur "L'identifiant n'existe pas."
    Et l'identifiant "Adrien" est toujours saisi
    Et le mot de passe "P4ssw0rd" est toujours saisi

    Scénario: Le mot de passe est incorrect
    Étant donné que l'utilisateur suivant existe :
    | Identifiant | Mot de passe |
    | Marc        | P0w3n3d      |
    Et que j'ai saisi l'identifiant "Marc"
    Et que j'ai saisi le mot de passe "P4ssw0rd"
    Et que je ne suis pas authentifié
    Alors j'ai le message d'erreur "Le mot de passe est incorrect."
    Et l'identifiant "Marc" est toujours saisi
    Et le mot de passe "P4ssw0rd" est toujours saisi

    Scénario: L'identifiant et le mot de passe sont corrects
    Étant donné que l'utilisateur suivant existe :
    | Identifiant | Mot de passe |
    | Marc        | P4ssw0rd     |
    Et que j'ai saisi l'identifiant "Marc"
    Et que j'ai saisi le mot de passe "P4ssw0rd"
    Et que je ne suis pas authentifié
    Alors je suis authentifié

    Scénario: Demande d'authentification via requête HTTP si déjà authentifié
    Étant donné que je suis déjà authentifié
    Et que j'ai saisi un identifiant et/ou un mot de passe ou non
    Quand je redemande une authentification directement via requête HTTP
    Alors je suis redirigé vers l'accueil 
    Et je suis toujours authentifié

    Scénario: Accès à l'écran d'authenficiation sans être authentifié
    Étant donné que je ne suis pas authentifié
    Quand je suis sur l'application
    Alors j'ai accès à l'écran d'authentification

    Scénario: Accès à l'écran d'authenficiation en étant authentifié
    Étant donné que je suis authentifié
    Quand je suis sur l'application
    Alors je n'ai plus accès à l'écran d'authentification