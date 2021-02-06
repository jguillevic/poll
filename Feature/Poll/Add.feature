Fonctionnalité: Créer un sondage
    En tant qu'utilisateur connecté
    Je veux pouvoir créer un sondage sur le site

    Un sondage est caractérisé par :
    - Une question
    - Une durée
    - Des réponses
    - Une date de création (non visible)
    - Un utilisateur associé (non visible)

    Scénario : Accès à la fonctionnalité d'ajout de sondage
    Étant donné que je ne suis pas authentifié
    Quand je m'authentifie
    Alors je vois un lien "Créer un sondage" dans la barre de navigation

    Scénario : Redirection vers la page d'accueil si pas authentifié
    Étant donné que je ne suis pas authentifié
    Quand je tape "/poll/add" dans l'adresse du navigateur
    Alors je suis redirigé vers la page d'accueil

    Scénario : Se rendre sur la page d'ajout de sondage
    Étant donné que je suis authentifié
    Quand je fais une requête autre que GET ou POST pour "/poll/add"
    Alors je suis redirigé vers la page d'accueil

    Scénario : Adresse de la fonctionnalité
    Étant donné que je suis authentifié
    Quand je clique sur le bouton "Créer un sondage"
    Alors l'adresse dans le navigateur est "/poll/add"

    Scénario : Se rendre sur la page d'ajout de sondage
    Étant donné que je suis authentifié
    Quand je clique sur le lien "Créer un sondage"
    Alors j'ai une zone de texte pour la question qui est vide
    Et j'ai une liste déroulante pour la durée prérenseignée sur 7 jours
    Et j'ai une zone d'ajout pour les réponses qui est vide
    Et j'ai un bouton de validation "Créer"

    Scénario : Les durées disponibles
    Étant donné que je suis sur la page de création de sondage
    Quand j'ouvre la liste des durées
    Alors j'ai 1j, 7j, 15j et 30j qui me sont proposés

    Scénario : La question n'est pas renseignée
    Étant donné que je n'ai pas renseigné de question
    Quand je valide l'ajout de mon sondage
    Alors j'ai le message d'erreur "La saisie de la question est obligatoire." sous la question

    Scénario : La question fait plus de 100 caractères
    Étant donné que je n'ai renseigné une question de plus de 100 caractères
    Quand je valide l'ajout de mon sondage
    Alors j'ai le message d'erreur "La question est trop longue (100 caractères max)." sous la question

    Scénario : La durée n'est pas renseignée
    Étant donné que je n'ai pas renseigné de durée
    Quand je valide l'ajout de mon sondage
    Alors la durée par défaut 7 j est affectée

    Scénario : Les réponses de ne sont pas renseignées
    Étant donné que j'ai renseigné la question
    Et je n'ai pas renseigné de réponses
    Quand je valide l'ajout de mon sondage
    Alors j'ai le message d'erreur "La saisie d'au moins deux réponses est obligatoire." sous les réponses 1 et 2

    Scénario : Seule la 1ère réponse est renseignée
    Étant donné que j'ai renseigné la question
    Et j'ai seulement renseigné la 1ère réponse
    Quand je valide l'ajout de mon sondage
    Alors j'ai le message d'erreur "La saisie d'au moins deux réponses est obligatoire." sous la réponse 2

    Scénario : Seule la réponse 2, 3, 4 ou 5 est renseignée
    Étant donné que j'ai renseigné la question
    Et j'ai seulement renseigné la réponse 2, 3, 4 ou 5
    Quand je valide l'ajout de mon sondage
    Alors j'ai le message d'erreur "La saisie d'au moins deux réponses est obligatoire." sous la réponse 1

    Scénario : Les réponses font plus de 100 caractères
    Étant donné que j'ai renseigné la question
    Et que j'ai renseigné une réponse de plus de 100 caractères
    Quand je valide l'ajout de mon sondage
    Alors j'ai le message d'erreur "La réponse est trop longue (100 caractères max)." sous la réponse

    Scénario : Enregistrement du sondage
    Étant donné que j'ai renseigné la question
    Et que j'ai renseigné au moins deux réponses
    Quand je valide l'ajout de mon sondage
    Alors le sondage est enregistré
    Et je suis redirigé vers la page d'accueil