# Installer le tchat sur une page de mon site web ?
## Requis
* Un nom de domaine avec hébergement web
* PHP 5.6 minimum
* Un peu d'expérience en html et php


## Mise en place de page-tchat.php
1. Téléchargez <code>page-tchat.php</code>: https://github.com/Discussionner/page-tchat/blob/master/page-tchat.php
2. Éditez le fichier <code>page-tchat.php</code> en changeant les paramètres <code>$apikey_authorization</code>, <code>$pre</code>, <code>$title</code> et <code>$channels</code>
3. Envoyez le fichier <code>page-tchat.php</code> par FTP
4. Exécutez <code>domaine.com/page-tchat.php?nick=nicktest&age=18&sex=H&from=Paris</code>
5. N'oubliez pas de demander le <key_authorization> au support technique: https://discussionner.com/support


## Documentation
### par GET
<code>/page-tchat.php?nick=nicktest&age=18&sex=H&from=Paris</code>
## par POST
* nick : Pseudo
* age : Age
* sex : H (homme), F (femme) ou I (inconnu)
* from : Département ou ville
* action: page-tchat.php

Pour toutes demandes techniques concernant ce script PHP, [contactez le support technique](https://discussionner.com/support)
