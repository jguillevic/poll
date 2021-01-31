Fonctionnalité: Créer un sondage
    En tant qu'utilisateur connecté
    Je veux pouvoir créer un sondage sur le site

    Un sondage est caractérisé par :
    - Une question
    - Une durée
    - Des réponses
    - Une date de création
    - Un utilisateur associé

    Scénario: Accès à la fonctionnalité d'ajout de sondage
    Étant donné que je ne suis pas authentifié
    Quand je m'authentifie
    Alors j'ai accès à la fonctionnalité d'ajout de sondage

    Scénario: Se rendre sur la page d'ajout de sondage
    Étant donné que je suis authentifié
    Quand j'accède à la page d'ajout de sondage
    Alors j'ai une entrée de texte pour la question qui est vide
    Et j'ai une liste déroulante pour la durée prérenseignée sur 7 jours
    Et j'ai une zone d'ajout pour les réponses qui est vide
    Et j'ai un bouton de validation "Créer"

    Scénario: Les durées disponibles
    Étant donné que je suis sur la page de création de sondage
    Quand j'ouvre la liste des durées
    Alors j'ai 1j, 7j, 15j et 30j qui me sont proposés

    Scénario: La question n'est pas renseignée
    Étant donné que je n'ai pas renseigné de question
    Quand je valide l'ajout de mon sondage
    Alors j'ai le message d'erreur "La saisie de la question est obligatoire"

    Scénario: Les réponses de ne sont pas renseignées
    Étant donné que j'ai renseigné la question
    Et je n'ai pas renseigné de réponses
    Quand je valide l'ajout de mon sondage
    Alors j'ai le message d'erreur "La saisie d'au moins deux réponses est obligatoire"

    Scénario: Enregistrement du sondage
    Étant donné que j'ai renseigné la question
    Et que j'ai renseigné au moins deux réponses
    Quand je valide l'ajout de mon sondage
    Alors le sondage est enregistré
    Et je suis redirigé vers la page de gestion de ce sondage